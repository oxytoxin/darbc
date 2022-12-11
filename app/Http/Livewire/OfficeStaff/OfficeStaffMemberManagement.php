<?php

namespace App\Http\Livewire\OfficeStaff;

use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\Shared\MemberManagement;

class OfficeStaffMemberManagement extends MemberManagement
{
    protected function getHistoryRoute(Model $record): string
    {
        return route('office-staff.member-dividends', ['member' => $record]);
    }

    protected function getMemberRestrictionsRoute(Model $record)
    {
        return route('office-staff.manage-member-restrictions', ['member' => $record]);
    }

    public function render()
    {
        return view('livewire.office-staff.office-staff-member-management');
    }
}
