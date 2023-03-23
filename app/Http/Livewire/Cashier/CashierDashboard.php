<?php

namespace App\Http\Livewire\Cashier;

use App\Models\User;
use App\Models\Release;
use Livewire\Component;
use App\Models\MemberInformation;
use Illuminate\Database\Eloquent\Builder;

class CashierDashboard extends Component
{
    public $from;
    public $to;

    public function mount()
    {
        $this->from = today()->format('Y-m-d');
        $this->to = today()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.cashier.cashier-dashboard', [
            'total_members_count' => MemberInformation::darbcMember()->count(),
            'deceased_members_count' => MemberInformation::deceased()->count(),
            'original_members_count' => MemberInformation::original()->count(),
            'replacement_members_count' => MemberInformation::replacement()->count(),
            'members_on_hold_count' => User::onHold()->count(),
            'latest_release' => Release::whereDisbursed(true)->latest()
                ->withCount(['dividends', 'released_dividends' => function (Builder $query) {
                    $query->where('released_by', auth()->id())
                        ->when($this->from, fn ($query) => $query->whereDate('released_at', '>=', $this->from))
                        ->when($this->to, fn ($query) => $query->whereDate('released_at', '<=', $this->to));
                }])
                ->withSum(['released_dividends as released_dividends_net_amount' => function (Builder $query) {
                    $query->where('released_by', auth()->id())
                        ->when($this->from, fn ($query) => $query->whereDate('released_at', '>=', $this->from))
                        ->when($this->to, fn ($query) => $query->whereDate('released_at', '<=', $this->to));
                }], 'net_amount')
                ->first(),
            'latest_releases' => Release::take(5)
                ->withSum('released_dividends as net', 'net_amount')
                ->latest()
                ->get(),
        ]);
    }
}
