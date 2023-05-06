<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Http\Livewire\Shared\MemberProfile;
use Livewire\Component;

class ReleaseAdminMemberProfile extends MemberProfile
{
    public function getEditRoute($member_id)
    {
        return route('release-admin.manage-members.edit', [
            'member' => $member_id
        ]);
    }
}
