<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Release;
use Livewire\Component;
use App\Models\MemberInformation;

class AdminDashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.admin-dashboard', [
            'active_members_count' => MemberInformation::active()->count(),
            'deceased_members_count' => MemberInformation::deceased()->count(),
            'original_members_count' => MemberInformation::original()->count(),
            'replacement_members_count' => MemberInformation::replacement()->count(),
            'members_on_hold_count' => User::onHold()->count(),
            'latest_release' => Release::latest()
                ->withCount(['dividends', 'released_dividends'])
                ->withSum('released_dividends as released_dividends_gross', 'gross_amount')
                ->withSum('released_dividends as released_dividends_deductions', 'deductions_amount')
                ->first(),
        ]);
    }
}
