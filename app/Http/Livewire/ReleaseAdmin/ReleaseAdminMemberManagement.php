<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Http\Livewire\Shared\MemberManagement;
use Illuminate\Database\Eloquent\Model;

class ReleaseAdminMemberManagement extends MemberManagement
{

    protected function getHistoryRoute(Model $record): string
    {
        return route('release-admin.member-dividends', ['member' => $record]);
    }

    protected function getMemberRestrictionsRoute(Model $record)
    {
        return route('release-admin.manage-member-restrictions', ['member' => $record]);
    }

    public function render()
    {
        return view('livewire.release-admin.release-admin-member-management');
    }
}