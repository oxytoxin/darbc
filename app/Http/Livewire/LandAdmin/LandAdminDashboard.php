<?php

namespace App\Http\Livewire\LandAdmin;

use App\Models\Gender;
use App\Models\MemberInformation;
use App\Models\MembershipStatus;
use App\Models\Occupation;
use App\Models\Release;
use App\Models\User;
use DB;
use Illuminate\Support\Str;
use Livewire\Component;

class LandAdminDashboard extends Component
{

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.land-admin.land-admin-dashboard');
    }
}
