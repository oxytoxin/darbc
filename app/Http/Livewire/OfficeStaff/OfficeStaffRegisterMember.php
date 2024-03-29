<?php

namespace App\Http\Livewire\OfficeStaff;

use App\Http\Livewire\Shared\RegisterMember;

class OfficeStaffRegisterMember extends RegisterMember
{

    protected function getRedirectionRoute()
    {
        return route('office-staff.manage-members');
    }
}
