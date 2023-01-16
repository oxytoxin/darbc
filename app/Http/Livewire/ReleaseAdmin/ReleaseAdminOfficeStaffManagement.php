<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\Role;

class ReleaseAdminOfficeStaffManagement extends ReleaseAdminAccountsManagement
{
    protected function getUserRole()
    {
        return Role::OFFICE_STAFF;
    }

    protected function getUserRoleName()
    {
        return 'Office Staff';
    }

    public function render()
    {
        return view('livewire.release-admin.release-admin-office-staff-management');
    }
}
