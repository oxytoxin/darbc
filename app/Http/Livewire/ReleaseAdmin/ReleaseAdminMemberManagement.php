<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Http\Livewire\Shared\MemberManagement;
use Illuminate\Database\Eloquent\Model;

class ReleaseAdminMemberManagement extends MemberManagement
{

    protected function getProfileRoute(Model $record): string
    {
        return route('release-admin.member-profile', ['member' => $record]);
    }

    protected function getMemberClaimsRoute(Model $record)
    {
        return route('release-admin.manage-member-claims', ['member' => $record]);
    }

    public function getExportRoute()
    {
        return route('release-admin.download-report.members', [
            'status' => $this->tableFilters['membership_status_id']['value'] ?? null,
        ]);
    }

    public function getAddMemberRoute()
    {
        return route('release-admin.register-members');
    }
}
