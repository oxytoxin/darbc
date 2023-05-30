<?php

namespace App\Http\Livewire\OfficeStaff;

use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\Shared\MemberManagement;

class OfficeStaffMemberManagement extends MemberManagement
{
    protected function getProfileRoute(Model $record): string
    {
        return route('office-staff.member-profile', ['member' => $record]);
    }

    public function getExportRoute()
    {
        return route('download-report.members', [
            'status' => $this->tableFilters['membership_status_id']['value'] ?? null,
        ]);
    }

    protected function getMemberClaimsRoute(Model $record)
    {
        return route('office-staff.manage-member-claims', ['member' => $record]);
    }

    public function getAddMemberRoute()
    {
        return route('office-staff.register-members');
    }
}
