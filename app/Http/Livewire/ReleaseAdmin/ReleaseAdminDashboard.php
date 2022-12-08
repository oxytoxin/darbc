<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\Dividend;
use App\Models\User;
use App\Models\Release;
use Livewire\Component;
use App\Models\MemberInformation;

class ReleaseAdminDashboard extends Component
{
    public function render()
    {
        return view('livewire.release-admin.release-admin-dashboard', [
            'active_members_count' => MemberInformation::active()->count(),
            'deceased_members_count' => MemberInformation::deceased()->count(),
            'original_members_count' => MemberInformation::original()->count(),
            'replacement_members_count' => MemberInformation::replacement()->count(),
            'members_on_hold_count' => User::onHold()->count(),
            'latest_release' => Release::whereDisbursed(true)->latest()
                ->withCount(['dividends', 'released_dividends'])
                ->withSum('released_dividends as released_dividends_gross', 'gross_amount')
                ->withSum('released_dividends as released_dividends_deductions', 'deductions_amount')
                ->first(),
            'recent_transactions' => Dividend::whereStatus(Dividend::RELEASED)->with(['cashier', 'user', 'release'])->latest()->take(7)->get(),
        ]);
    }
}
