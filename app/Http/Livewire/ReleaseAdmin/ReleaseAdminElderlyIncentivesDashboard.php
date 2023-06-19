<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Http\Livewire\Shared\ElderlyIncentivesDashboard;
use Livewire\Component;

class ReleaseAdminElderlyIncentivesDashboard extends ElderlyIncentivesDashboard
{

    protected function getIncentivesAwardedRoute(): string
    {
        return route('release-admin.elderly-incentives-management');
    }
}
