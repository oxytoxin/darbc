<?php

namespace App\Http\Livewire\LandAdmin;

use App\Models\LotInformation;
use Livewire\Component;
use Livewire\WithPagination;

class LandAdminDashboard extends Component
{
    use WithPagination;

    public $drawDateModal = false;
    public $drawDate;
    public $ownerId;

    public $search;

    public function render()
    {
        return view('livewire.land-admin.land-admin-dashboard', [
            'informations' => LotInformation::with('user', 'block', 'lot', 'area')
                ->whereHas('user', function ($query) {
                    $query->where('first_name', 'like', "%{$this->search}%")
                        ->orWhere('surname', 'like', "%{$this->search}%");
                })
                ->paginate(10)
        ]);
    }
    // 'informations' => LotInformation::with('user', 'block', 'lot', 'area')->paginate(5),

    public function showModal($id)
    {
        $this->ownerId = $id;
        $this->drawDateModal = true;
    }

    public function saveDrawDate()
    {
        LotInformation::where('id', $this->ownerId)->update(['draw_date' => $this->drawDate]);
        $this->drawDateModal = false;
    }
}
