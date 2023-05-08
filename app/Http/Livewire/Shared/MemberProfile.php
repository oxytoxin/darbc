<?php

namespace App\Http\Livewire\Shared;

use App\Models\MemberInformation;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MemberProfile extends Component implements HasForms
{

    use InteractsWithForms;

    public MemberInformation $member;
    public $route_name;
    public $percentage;
    public $documents;

    protected function getFormModel()
    {
        return $this->member;
    }

    protected function getFormSchema(): array
    {
        return [
            FileUpload::make('documents')
                ->multiple()
                ->label('Upload Documents'),
        ];
    }

    public function mount()
    {
        $this->form->fill();
        $this->route_name = request()->route()->getName();
        $this->percentage = $this->member->percentage;
    }

    public function saveDocuments()
    {
        if (count($this->documents)) {
            foreach ($this->documents as $key => $document) {
                $this->member->addMedia($document->getRealPath())
                    ->usingFileName($document->getClientOriginalName())
                    ->toMediaCollection('documents');
            }
            $this->reset('documents');
            $this->member->refresh();
            notify();
        }
    }

    public function deleteDocument(Media $document)
    {
        if ($document->model_id != $this->member->id) {
            return;
        }
        $document->delete();
        $this->member->refresh();
        notify();
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
