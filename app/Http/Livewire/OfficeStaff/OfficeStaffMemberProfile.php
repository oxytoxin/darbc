<?php

namespace App\Http\Livewire\OfficeStaff;

use App\Http\Livewire\Shared\MemberProfile;
use Livewire\Component;

class OfficeStaffMemberProfile extends MemberProfile
{
    public function getEditRoute($member_id)
    {
        return route('office-staff.manage-members.edit', [
            'member' => $member_id
        ]);
    }
}
