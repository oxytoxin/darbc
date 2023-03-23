<?php

namespace App\Http\Livewire\OfficeStaff;

use App\Models\User;
use Livewire\Component;
use App\Models\MemberInformation;
use App\Models\Release;

class OfficeStaffDashboard extends Component
{
    public function render()
    {
        return view('livewire.office-staff.office-staff-dashboard', [
            'total_members_count' => MemberInformation::darbcMember()->count(),
            'deceased_members_count' => MemberInformation::deceased()->count(),
            'original_members_count' => MemberInformation::original()->count(),
            'replacement_members_count' => MemberInformation::replacement()->count(),
            'members_on_hold_count' => User::onHold()->count(),
            'latest_release' => Release::whereDisbursed(true)->latest()
                ->withCount(['dividends', 'released_dividends'])
                ->withSum('released_dividends as released_dividends_net', 'net_amount')
                ->first(),
        ]);
    }
}
