<?php

namespace App\Http\Livewire\OfficeStaff;

use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\Shared\MemberManagement;

class OfficeStaffMemberManagement extends MemberManagement
{
    protected function getProfileRoute(Model $record): string
    {
        return route('office-staff.member-dividends', ['member' => $record]);
    }

    public function getExportRoute()
    {
        return route('office-staff.download-report.members', [
            'status' => $this->tableFilters['membership_status_id']['value'] ?? null,
        ]);
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
