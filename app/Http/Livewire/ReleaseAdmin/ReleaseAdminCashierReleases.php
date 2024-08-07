<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\Role;
use App\Models\User;
use App\Models\Release;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ReleaseAdminCashierReleases extends Component
{
    public $release_id;
    public $from;
    public $to;

    public function mount()
    {
        $this->from = today()->format('Y-m-d H:i');
        $this->to = today()->addDay()->format('Y-m-d H:i');
        $this->release_id = Release::latest()->whereDisbursed(true)->first()->id;
    }

    public function render()
    {
        $selected_release = Release::whereDisbursed(true)->latest()
            ->withCount(['dividends', 'released_dividends' => function (Builder $query) {
                $query->when($this->from, fn ($query) => $query->where('released_at', '>=', $this->from))
                    ->when($this->to, fn ($query) => $query->where('released_at', '<=', $this->to));
            }])
            ->withSum(['released_dividends as released_dividends_net' => function (Builder $query) {
                $query->when($this->from, fn ($query) => $query->where('released_at', '>=', $this->from))
                    ->when($this->to, fn ($query) => $query->where('released_at', '<=', $this->to));
            }], 'net_amount')
            ->withCount('released_dividends as overall_released_dividends_count')
            ->withSum('released_dividends as overall_released_dividends_net', 'net_amount')
            ->find($this->release_id);
        return view('livewire.release-admin.release-admin-cashier-releases', [
            'selected_release' => $selected_release,
            'cashiers' => User::whereRelation('roles', 'role_id', Role::CASHIER)
                ->whereActive(true)
                ->withCount(['cashier_released_dividends' => fn ($query) => $query
                    ->when($this->from, fn ($q) => $q->where('released_at', '>=', $this->from))
                    ->when($this->to, fn ($q) => $q->where('released_at', '<=', $this->to))
                    ->whereReleaseId($this->release_id)])
                ->withSum(['cashier_released_dividends as cashier_released_dividends_net' => fn ($query) => $query
                    ->when($this->from, fn ($q) => $q->where('released_at', '>=', $this->from))
                    ->when($this->to, fn ($q) => $q->where('released_at', '<=', $this->to))
                    ->whereReleaseId($this->release_id)], 'net_amount')
                ->get(),
            'releases' => Release::latest()->get(),
        ]);
    }
}
