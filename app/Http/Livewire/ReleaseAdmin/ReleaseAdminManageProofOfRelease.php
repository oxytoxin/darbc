<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\Dividend;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Intervention\Image\Facades\Image;
use Filament\Notifications\Notification;

class ReleaseAdminManageProofOfRelease extends Component implements HasForms
{
    use InteractsWithForms;

    public Dividend $dividend;
    public $proof_of_release;
    public $old_proof_of_release;
    public $uploaded_proof;

    protected function getFormSchema()
    {
        return [
            FileUpload::make('uploaded_proof')
                ->label('Upload Proof Of Release Image')
                ->image(),
        ];
    }

    public function mount()
    {
        $this->old_proof_of_release = $this->dividend->getFirstMedia('proof_of_release');
    }

    public function render()
    {
        return view('livewire.release-admin.release-admin-manage-proof-of-release');
    }

    public function saveUploadedProof()
    {
        $proof = collect($this->uploaded_proof)->first();
        if ($proof) {
            $this->dividend->addMedia($proof->getRealPath())->toMediaCollection('proof_of_release');
            $this->old_proof_of_release = $this->dividend->getFirstMedia('proof_of_release');
            Notification::make()->title('Proof of Release Uploaded!')->success()->send();
        }
    }

    public function captureProofOfRelease($data)
    {
        $this->proof_of_release = $data;

        if ($this->proof_of_release) {
            $path = storage_path('app/proof_of_release/' . $this->dividend->id . '-' . now()->timestamp . '-proof.png');
            Image::make($this->proof_of_release)->save($path);
            $this->dividend->addMedia($path)->toMediaCollection('proof_of_release');
        }
        $this->old_proof_of_release = $this->dividend->getFirstMedia('proof_of_release');
        Notification::make()->title('Proof of Release Captured!')->success()->send();
        $this->emitSelf('closeModal');
    }
}
