<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\Dividend;
use App\Models\Release;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ReleaseAdminReportsIndex extends Component
{
    public $release_id;

    public function mount()
    {
        $this->release_id = Release::latest()->first()->id;
    }

    public function render()
    {
        return view('livewire.release-admin.release-admin-reports-index', [
            'releases' => Release::latest()->get(),
            'cashiers' => User::whereRelation('roles', 'role_id', Role::CASHIER)
                ->withCount([
                    'cashier_released_dividends as releases_count' => fn ($query) => $query
                        ->whereReleaseId($this->release_id),
                    'cashier_released_dividends as voided_count' => fn ($query) => $query
                        ->whereReleaseId($this->release_id)
                        ->whereVoided(true),
                ])
                ->get(),
            'selected_release' => Release::withCount([
                'unclaimed_dividends',
                'onhold_dividends',
                'released_dividends',
                'voided_dividends',
                'member_claimed_dividends',
                'spa_claimed_dividends',
                'representative_claimed_dividends',
            ])->find($this->release_id),
        ]);
    }
}
