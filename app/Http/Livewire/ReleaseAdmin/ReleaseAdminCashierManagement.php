<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\Role;

class ReleaseAdminCashierManagement extends ReleaseAdminAccountsManagement
{
    protected function getUserRole()
    {
        return Role::CASHIER;
    }

    protected function getUserRoleName()
    {
        return 'Cashier';
    }

    public function render()
    {
        return view('livewire.release-admin.release-admin-cashier-management');
    }
}
