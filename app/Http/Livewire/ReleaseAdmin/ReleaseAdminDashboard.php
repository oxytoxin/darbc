<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\Dividend;
use App\Models\User;
use App\Models\Release;
use Livewire\Component;
use App\Models\MemberInformation;
use App\Models\Role;
use Carbon\Carbon;

class ReleaseAdminDashboard extends Component
{
    public $release_id;
    public $from;
    public $to;

    public function mount()
    {
        $this->from = today()->format('Y-m-d H:i');
        $this->to = today()->format('Y-m-d H:i');
        $this->release_id = Release::latest()->whereDisbursed(true)->first()->id;
    }

    public function render()
    {
        $selected_release = Release::whereDisbursed(true)->latest()
            ->withCount(['dividends', 'released_dividends'])
            ->withSum('released_dividends as released_dividends_gross', 'gross_amount')
            ->withSum('released_dividends as released_dividends_deductions', 'deductions_amount')
            ->find($this->release_id);


        return view('livewire.release-admin.release-admin-dashboard', [
            'total_members_count' => MemberInformation::darbcMember()->count(),
            'deceased_members_count' => MemberInformation::deceased()->count(),
            'original_members_count' => MemberInformation::original()->count(),
            'replacement_members_count' => MemberInformation::replacement()->count(),
            'members_on_hold_count' => User::onHold()->count(),
            'selected_release' => $selected_release,
            'releases' => Release::get(),
            'recent_transactions' => Dividend::whereStatus(Dividend::RELEASED)->with(['cashier', 'user', 'release'])->latest('released_at')->take(7)->get(),
            'cashiers' => User::whereRelation('roles', 'role_id', Role::CASHIER)
                ->withCount(['cashier_released_dividends' => fn ($query) => $query
                    ->when($this->from, fn ($q) => $q->where('released_at', '>=', $this->from))
                    ->when($this->to, fn ($q) => $q->where('released_at', '<=', $this->to))
                    ->whereReleaseId($this->release_id)])
                ->withSum(['cashier_released_dividends as cashier_released_dividends_gross' => fn ($query) => $query
                    ->when($this->from, fn ($q) => $q->where('released_at', '>=', $this->from))
                    ->when($this->to, fn ($q) => $q->where('released_at', '<=', $this->to))
                    ->whereReleaseId($this->release_id)], 'gross_amount')
                ->withSum(['cashier_released_dividends as cashier_released_dividends_deductions' => fn ($query) => $query
                    ->when($this->from, fn ($q) => $q->where('released_at', '>=', $this->from))
                    ->when($this->to, fn ($q) => $q->where('released_at', '<=', $this->to))
                    ->whereReleaseId($this->release_id)], 'deductions_amount')
                ->get(),
        ]);
    }
}
