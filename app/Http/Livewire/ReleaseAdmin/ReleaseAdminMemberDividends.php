<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Http\Livewire\Shared\MemberDividends;

class ReleaseAdminMemberDividends extends MemberDividends
{
    public function getEditRoute($member_id)
    {
        return route('release-admin.manage-members.edit', [
            'member' => $member_id
        ]);
    }
}
