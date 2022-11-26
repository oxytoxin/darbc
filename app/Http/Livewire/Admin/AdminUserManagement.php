<?php

namespace App\Http\Livewire\Admin;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class AdminUserManagement extends Component
{
    public function render()
    {
        return view('livewire.admin.admin-user-management');
    }
}
