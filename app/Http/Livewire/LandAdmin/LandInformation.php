<?php

namespace App\Http\Livewire\LandAdmin;

use Livewire\Component;
use App\Models\LotInformation;
use App\Models\MapImage;
use Livewire\WithFileUploads;

class LandInformation extends Component
{
    use WithFileUploads;

    public $information = [];
    public $landId;

    public $mapImage;
    public $ownerInfo;

    public function mount($id)
    {
        $this->landId = $id;
        $this->ownerInfo = LotInformation::where('id', $this->landId)->first();
    }

    public function render()
    {
        return view('livewire.land-admin.land-information', [
            'land' => LotInformation::with('user', 'block', 'lot', 'area')->where('id', $this->landId)->first()
        ]);
    }

    public function updateMap()
    {
        $imageName = $this->mapImage->store('maps', 'public');

        $this->ownerInfo->update(['map_url' => str_replace("maps/", "", $imageName)]);
        dd('Updated');
    }
}
