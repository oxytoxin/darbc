<?php

namespace App\Http\Livewire\Rsbsa;

use Livewire\Component;
use App\Models\MemberInformation;

class RsbsaDashboard extends Component
{
    public function render()
    {

        return view('livewire.rsbsa.rsbsa-dashboard', [
            'total_active_member_where_has_rsbsa' => MemberInformation::whereStatus(MemberInformation::STATUS_ACTIVE)
                ->whereHas('rsbsa') // Ensures member has an RsbsaRecord
                ->count(),

            'total_active_member_where_doesnt_have' => MemberInformation::whereStatus(MemberInformation::STATUS_ACTIVE)
                ->whereDoesntHave('rsbsa') // Ensures member DOES NOT have an RsbsaRecord
                ->count(),
        ]);
        
    }
}
