<?php

namespace App\Http\Livewire\OfficeStaff;

use App\Http\Livewire\Shared\MemberRestrictionsManagement;

class OfficeStaffMemberRestrictionsManagement extends MemberRestrictionsManagement
{

    public function render()
    {
        return view('livewire.office-staff.office-staff-member-restrictions-management');
    }
}
