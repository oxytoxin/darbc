<?php

namespace App\Http\Livewire\Admin;

use App\Models\MemberInformation;
use App\Models\User;
use Livewire\Component;

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
        ]);
    }
}
