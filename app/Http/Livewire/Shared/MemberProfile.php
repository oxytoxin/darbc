<?php

namespace App\Http\Livewire\Shared;

use App\Models\MemberInformation;
use Livewire\Component;

class MemberProfile extends Component
{
    public MemberInformation $member;
    public $route_name;
    public $percentage;

    public function mount()
    {
        $this->route_name = request()->route()->getName();
        $this->percentage = $this->member->percentage;
    }

    public function save()
    {
        $this->percentage = floatval($this->percentage);
        $this->member->update([
            'percentage' => $this->percentage,
        ]);
        notify();
    }

    public function getEditRoute($member_id)
    {
        return '#';
    }

    public function render()
    {
        return view('livewire.shared.member-profile', [
            'lineage_members' => MemberInformation::with('user')->whereLineageIdentifier($this->member->lineage_identifier)->orderByDesc('succession_number')->get(),
        ]);
    }
}
