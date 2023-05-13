<?php

namespace App\Http\Livewire\OfficeStaff;

use App\Http\Livewire\Shared\UpdateMemberInformation;

class OfficeStaffUpdateMemberInformation extends UpdateMemberInformation
{
    public function getProfileRoute()
    {
        return route('office-staff.member-profile', $this->member->id);
    }
}
