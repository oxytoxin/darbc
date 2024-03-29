<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Http\Livewire\Shared\RegisterMember;

class ReleaseAdminRegisterMember extends RegisterMember
{
    protected function getRedirectionRoute()
    {
        return route('release-admin.manage-members');
    }
}
