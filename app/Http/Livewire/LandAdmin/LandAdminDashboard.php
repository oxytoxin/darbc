<?php

namespace App\Http\Livewire\LandAdmin;

use App\Models\Release;
use Livewire\Component;

class LandAdminDashboard extends Component
{
    public function render()
    {
        return view('livewire.land-admin.land-admin-dashboard');
    }
}
