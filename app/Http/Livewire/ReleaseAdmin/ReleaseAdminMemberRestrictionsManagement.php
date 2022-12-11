<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Http\Livewire\Shared\MemberRestrictionsManagement;

class ReleaseAdminMemberRestrictionsManagement extends MemberRestrictionsManagement
{

    public function render()
    {
        return view('livewire.release-admin.release-admin-member-restrictions-management');
    }
}
