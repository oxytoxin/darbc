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

    public function mount(RsbsaRecord $rsbsa)
    {
        $this->rsbsa = $rsbsa;
        $data = $this->rsbsa->toArray();
        $data = array_merge($data, [
            'darbc_id' => $this->rsbsa->memberInformation->darbc_id ?? null,
            'memberInformation_information_id' => $this->rsbsa->memberInformation->id ?? null,
            'user_id' => $this->rsbsa->memberInformation->user_id ?? null,
            // 'surname' => $this->rsbsa->memberInformation->user?->surname ?? null,
            // 'first_name' => $this->rsbsa->memberInformation->user?->first_name ?? null,
            // 'middle_name' => $this->rsbsa->memberInformation->user?->middle_name ?? null,
            // 'gender' => $this->rsbsa->memberInformation?->gender->name ?? null,
            // 'date_of_birth' => $this->rsbsa->memberInformation?->date_of_birth ?? null,
            // 'contact_number' => $this->rsbsa->memberInformation?->contact_number ?? null,
            // 'religion' => $this->rsbsa->memberInformation?->religion ?? null,
            // 'civil_status' => $this->rsbsa->memberInformation?->civil_status ?? null,
            // 'name_of_spouse' => $this->rsbsa->memberInformation?->spouse ?? null,
            // 'mother_maiden_name' => $this->rsbsa->memberInformation?->mother_maiden_name ?? null,
        ]);

        $twoByTwoMediaPath = $this->rsbsa->getFirstMediaPath('two_by_two');

    // Set FileUpload field correctly (must be a file path, not URL)
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

        $validatedData = $this->form->validate();

        $twoByTwo['two_by_two'] = $validatedData['two_by_two'];
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
