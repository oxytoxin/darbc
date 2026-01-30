<?php

namespace App\Http\Livewire\Rsbsa;

use Closure;
use Livewire\Component;
use App\Models\RsbsaRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use App\Http\Controllers\Rsbase\RsbsaFroms;
use Filament\Forms\Concerns\InteractsWithForms;

class EditRsbsa extends Component implements HasForms
{
    use InteractsWithForms;

    public RsbsaRecord $rsbsa;
    public $data;

    protected function getFormSchema(): array
    {
        return RsbsaFroms::editForm($this->rsbsa);
    }

    protected function getFormStatePath(): ?string
    {
        return 'data';
    }

    public function mount(RsbsaRecord $rsbsa)
    {
        $this->rsbsa = $rsbsa;
        $member = $this->rsbsa->memberInformation;
        $data = $this->rsbsa->toArray();

        $data = array_merge($data, [
            'darbc_id' => $member->darbc_id ?? null,
            'memberInformation_information_id' => $member->id ?? null,
            'user_id' => $member->user_id ?? null,
        ]);

        // Auto-fill empty personal details from Member (recommended for better UX)
        if (empty($data['surname'])) {
            $data['surname'] = $member->user?->surname;
        }
        if (empty($data['first_name'])) {
            $data['first_name'] = $member->user?->first_name;
        }
        if (empty($data['middle_name'])) {
            $data['middle_name'] = $member->user?->middle_name;
        }
        if (empty($data['gender_id'])) {
            $data['gender_id'] = $member->gender?->id;
        }
        if (empty($data['date_of_birth'])) {
            $data['date_of_birth'] = $member->date_of_birth;
        }
        if (empty($data['contact_number'])) {
            $data['contact_number'] = $member->contact_number;
        }
        if (empty($data['religion'])) {
            $data['religion'] = $member->religion;
        }
        if (empty($data['civil_status'])) {
            $data['civil_status'] = $member->civil_status;
        }
        if (empty($data['name_of_spouse'])) {
            $data['name_of_spouse'] = $member->spouse;
        }
        if (empty($data['mother_maiden_name'])) {
            $data['mother_maiden_name'] = $member->mother_maiden_name;
        }
        if (empty($data['barangay'])) {
            $data['barangay'] = $member->barangay;
        }

        // Validate location codes - clear invalid ones so user can re-select
        if (!empty($data['region_code']) && !\App\Models\Region::where('code', $data['region_code'])->exists()) {
            $data['region_code'] = null;
        }
        if (!empty($data['province_code']) && !\App\Models\Province::where('code', $data['province_code'])->exists()) {
            $data['province_code'] = null;
        }
        if (!empty($data['city_municipality_code']) && !\App\Models\City::where('code', $data['city_municipality_code'])->exists()) {
            $data['city_municipality_code'] = null;
        }
        if (!empty($data['barangay_code']) && !\App\Models\Barangay::where('code', $data['barangay_code'])->exists()) {
            $data['barangay_code'] = null;
        }

        $twoByTwoMediaPath = $this->rsbsa->getFirstMediaPath('two_by_two');
        $data['two_by_two'] = !empty($twoByTwoMediaPath) ? $twoByTwoMediaPath : null;

        $this->form->fill($data);
    }

    public function update()
    {
        try {
            $this->form->validate();
        } catch (\Throwable $th) {
            notify(title: $th->getMessage(), type: 'danger');
            throw $th;
        }

        DB::beginTransaction();

        $validatedData = $this->form->validate()['data'];

        $twoByTwo['two_by_two'] = $validatedData['two_by_two'] ?? null;
        $validatedData['enrollment_type'] = 'Updating';
        unset($validatedData['two_by_two']);


        // unset(
        //     $validatedData['darbc_id'],
        //     $validatedData['memberInformation_information_id'],
        //     $validatedData['user_id'],
        //     $validatedData['surname'],
        //     $validatedData['first_name'],
        //     $validatedData['middle_name'],
        //     $validatedData['gender'],
        //     $validatedData['date_of_birth'],
        //     $validatedData['contact_number'],
        //     $validatedData['religion'],
        //     $validatedData['civil_status'],
        //     $validatedData['name_of_spouse'],
        //     $validatedData['mother_maiden_name'],

        // );
        // dd($validatedData);
        $this->rsbsa->update($validatedData);
        if ($twoByTwo['two_by_two']) {
            $this->rsbsa->addMedia(collect( $twoByTwo['two_by_two'])?->first())->toMediaCollection('two_by_two');
        }



        DB::commit();

        Notification::make()
            ->title('Success!')
            ->body('The RSBSA record has been successfully updated.')
            ->success()
            ->send();

        return redirect()->route('rsbsa.manage-members');

    }


    public function render()
    {
        return view('livewire.rsbsa.edit-rsbsa');
    }

    
}
