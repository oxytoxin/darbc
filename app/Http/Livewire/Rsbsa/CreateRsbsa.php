<?php

namespace App\Http\Livewire\Rsbsa;

use Closure;

use App\Models\City;
use App\Models\Region;
use Livewire\Component;
use App\Models\Barangay;
use App\Models\Province;
use App\Models\RsbsaRecord;
use App\Models\MemberInformation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use App\Forms\Components\VerticalWizard;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Wizard\Step;
use App\Http\Controllers\Rsbase\RsbsaFroms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateRsbsa extends Component implements HasForms
{
    use InteractsWithForms;
    public MemberInformation $member;
    public $data;
    public $rsbsa;


    protected function getFormSchema(): array
    {
        return RsbsaFroms::createForm();
    }



    public function register()
{
    DB::beginTransaction();

    try {
        // Validate the form data using Filament's form validation
        $validatedData = $this->form->validate()['data'];
        // dd($validatedData);


        // Pull out keys that are handled separately (not direct columns).
        $twoByTwo = $validatedData['two_by_two'] ?? null;
        $farmParcels = $validatedData['farm_parcels'] ?? [];
        unset($validatedData['two_by_two'], $validatedData['farm_parcels']);

        // Every remaining form field maps 1:1 to a column; add system fields.
        $rsbsaRecord = RsbsaRecord::create(array_merge($validatedData, [
            'enrollment_type'       => 'New',
            'darbc_id'              => $this->member->darbc_id,
            'user_id'               => $this->member->user_id,
            'member_information_id' => $this->member->id,
        ]));

        if ($twoByTwo) {
            $rsbsaRecord->addMedia(collect($twoByTwo)->first())->toMediaCollection('two_by_two');
        }

        $rsbsaRecord->syncFarmParcels($farmParcels);

        DB::commit();

        // Notify success
        Notification::make()
            ->title('Success!')
            ->body('The RSBSA record has been successfully created.')
            ->success()
            ->send();

        // Redirect or reset form
        // dd($rsbsaRecord);
        return redirect()->route('rsbsa.manage-members'); // Replace with your actual route
    } catch (\Throwable $e) {
        DB::rollBack();

        // Notify failure
        Notification::make()
            ->title('Error!')
            ->body('There was an error saving the RSBSA record: ' . $e->getMessage())
            ->danger()
            ->send();

        throw $e;
    }
}


    // protected function getFormModel(): RsbsaRecord
    // {
    //     // return RsbsaRecord::cl;
    // }
    protected function getFormStatePath(): ?string
    {
        return 'data';
    }
    public function mount()
{
    //   dd($this->member);
    // dd($this->member->gender);
    $this->form->fill([
        'darbc_id'=> $this->member->darbc_id,
        'member_information_id'=> $this->member->id,
        'user_id'=> $this->member->user_id,
        'surname'=> $this->member->user?->surname,
        'first_name'=> $this->member->user?->first_name,
        'middle_name'=> $this->member->user?->middle_name,

        'gender_id'=> $this->member?->gender->id,
        'date_of_birth'=> $this->member?->date_of_birth,
        'contact_number'=> $this->member?->contact_number,
        'religion'=> $this->member?->religion,
        'barangay'=> $this->member?->barangay,
        'civil_status'=> $this->member?->civil_status,
        'name_of_spouse'=> $this->member?->spouse,
        'mother_maiden_name'=> $this->member?->mother_maiden_name,
        // 'landline_number'=> $this->member?->landline_number,
        // 'middle_name'=> $this->member->user?->middle_name,
        ]);
    }
    public function render()
    {
        return view('livewire.rsbsa.create-rsbsa');
    }
}
