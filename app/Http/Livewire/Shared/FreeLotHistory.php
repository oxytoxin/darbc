<?php

namespace App\Http\Livewire\Shared;

use App\Models\FreeLot;
use Livewire\Component;

class FreeLotHistory extends Component
{
    public FreeLot $free_lot;

    public function render()
    {
        return view('livewire.shared.free-lot-history');
    }
}
