<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class ReleaseAdminUserManagement extends Component
{
    public function render()
    {
        return view('livewire.release-admin.release-admin-user-management');
    }
}
