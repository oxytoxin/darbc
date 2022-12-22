<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\Dividend;
use App\Models\User;
use App\Models\Release;
use Livewire\Component;
use App\Models\MemberInformation;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ReleaseAdminDashboard extends Component
{




    public function render()
    {
        return view('livewire.release-admin.release-admin-dashboard', [
            'total_members_count' => MemberInformation::darbcMember()->count(),
            'deceased_members_count' => MemberInformation::deceased()->count(),
            'original_members_count' => MemberInformation::original()->count(),
            'replacement_members_count' => MemberInformation::replacement()->count(),
            'members_on_hold_count' => User::onHold()->count(),
            'recent_transactions' => Dividend::whereStatus(Dividend::RELEASED)->with(['cashier', 'user', 'release'])->latest('released_at')->take(7)->get(),
        ]);
    }
}
