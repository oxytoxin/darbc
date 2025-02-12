<?php

namespace App\Http\Livewire\Rsbsa;

use Livewire\Component;
use App\Models\RsbsaRecord;

class ViewRsbsa extends Component
{
    
    public RsbsaRecord $rsbsa;

    public function mount(RsbsaRecord $rsbsa)
    {
        $this->rsbsa = $rsbsa;
    }

    public function render()
    {
        return view('livewire.rsbsa.view-rsbsa', [
            'rsbsa' => $this->rsbsa
        ]);
    }
}
