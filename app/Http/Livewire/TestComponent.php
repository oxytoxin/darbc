<?php

namespace App\Http\Livewire;

use App\Models\ElderlyIncentive;
use App\Models\MemberInformation;
use Livewire\Component;
use Route;
use Spatie\SimpleExcel\SimpleExcelWriter;

class TestComponent extends Component
{
    public function render()
    {
        return view('livewire.test-component');
    }

    public function mount()
    {
    }
}
