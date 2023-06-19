<?php

namespace App\Http\Livewire\OfficeStaff;

use App\Http\Livewire\Shared\ElderlyIncentivesDashboard;
use Livewire\Component;

class OfficeStaffElderlyIncentivesDashboard extends ElderlyIncentivesDashboard
{
    protected function getIncentivesAwardedRoute(): string
    {
        return route('office-staff.elderly-incentives-management');
    }
}
