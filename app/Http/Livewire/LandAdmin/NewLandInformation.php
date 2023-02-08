<?php

namespace App\Http\Livewire\LandAdmin;

use App\Models\AreaAddress;
use App\Models\BlockAddress;
use App\Models\LotAddress;
use App\Models\LotInformation;
use App\Models\MapImage;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewLandInformation extends Component
{
    use WithFileUploads;

    public $mapImage;

    public $ownerId;
    public $search;

    public $fileDocuments = [];

    public $firstName;
    public $middleName;
    public $surname;
    public $suffix;

    public $block;
    public $lot;
    public $area;
    public $status;

    public $collapseExpand = false;

    // 'file' => 'required|mimes:png,jpg,jpeg,csv,pdf|max:2048', // 2MB Max
    public function render()
    {
        return view('livewire.land-admin.new-land-information', [
            'informations' => LotInformation::with('user')
                ->whereHas('user', function ($query) {
                    $query->where('first_name', 'like', "%{$this->search}%")
                        ->orWhere('surname', 'like', "%{$this->search}%");
                })->get(),
            'blocks' => BlockAddress::all(),
            'lots' => LotAddress::all(),
            'areas' => AreaAddress::all(),
        ]);
    }

    public function saveLandOwnerInfo(){
        dd('Working...');
        // $land = LotInformation::create([
        //     'user_id' => $this->ownerId,
        //     'block_id' => $this->block,
        //     'lot_id' => $this->lot,
        //     'area_id' => $this->area,
        // ]);

        // if($this->status == 1){
        //     $land->update(['status'=> 1]);
        // }
    }

    public function makeAsOwner($id)
    {
        $this->collapseExpand = false;

        $info = LotInformation::find($id);
        $owner = User::where('id', $info->user_id)->get();

        $this->ownerId = $info->user_id;

        foreach ($owner as $user) {
            $this->firstName = $user->first_name;
            $this->middleName = $user->middle_name;
            $this->surname = $user->surname;
            $this->suffix = $user->suffix;
        }

        $this->search = "";
        $this->collapseExpand = true;
    }

    public function saveMap(){
        // filename
        $this->original_filename = $this->mapImage->getClientOriginalName();
        
        // Check file extension is an image type
        // $extension = strtolower($this->file->extension());
        // $image_exts = array('png','jpg','jpeg');
        // if(in_array($extension,$image_exts)){
        //     $this->isImage = true;
        // }
        
        $imageName = $this->mapImage->store('maps', 'public');
        // $imageName = $this->mapImage->storeAs('maps', $this->original_filename);
        
        MapImage::create([
            'user_id' => $this->ownerId,
        ]);

        dd('Uploaded');
    }
}