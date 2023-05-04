<?php

namespace App\Http\Livewire\OfficeStaff;

use App\Http\Livewire\Shared\MemberDividends;

class OfficeStaffMemberDividends extends MemberDividends
{
    public function getEditRoute($member_id)
    {
        return route('release-admin.manage-members.edit', [
            'member' => $member_id
        ]);
    }
}
