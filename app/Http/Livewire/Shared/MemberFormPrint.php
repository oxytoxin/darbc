<?php

namespace App\Http\Livewire\Shared;

use App\Models\MemberInformation;
use Livewire\Component;

class MemberFormPrint extends Component
{
    public MemberInformation $member;

    public function render()
    {
        return view('livewire.shared.member-form-print');
    }
}
