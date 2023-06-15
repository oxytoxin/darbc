<?php

namespace App\Http\Livewire\Shared;

use App\Models\MemberInformation;
use Livewire\Component;

class ElderlyIncentivesDashboard extends Component
{
    public function mount()
    {
        dd(MemberInformation::withAge()->first());
    }

    public function render()
    {
        return view('livewire.shared.elderly-incentives-dashboard');
    }
}
