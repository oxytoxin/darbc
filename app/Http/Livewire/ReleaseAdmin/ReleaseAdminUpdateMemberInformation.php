<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Http\Livewire\Shared\UpdateMemberInformation;

class ReleaseAdminUpdateMemberInformation extends UpdateMemberInformation
{
    public function getProfileRoute()
    {
        return route('release-admin.member-profile', $this->member->id);
    }
}
