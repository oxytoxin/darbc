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
    
      
        $rsbsaData = [
            'darbc_id' => $this->member->darbc_id,
            'member_information_id' => $this->member->id,
            'user_id' => $this->member->user_id,
            'enrollment_type' => 'New',
            'region_code' => $validatedData['region_code'] ?? null,
            'province_code' => $validatedData['province_code'] ?? null,
            'city_municipality_code' => $validatedData['city_municipality_code'] ?? null,
            'barangay_code' => $validatedData['barangay_code'] ?? null,
            'extension_name' => $validatedData['extension_name'] ?? null,
            'house_lot_bldg_purok' => $validatedData['house_lot_bldg_purok'] ?? null,
            'street_sitio_subdv' => $validatedData['street_sitio_subdv'] ?? null,
            'barangay' => $validatedData['barangay'] ?? null,
            'city_municipality' => $validatedData['city_municipality'] ?? null,
            'province' => $validatedData['province'] ?? null,
            'region' => $validatedData['region'] ?? null,
            'landline_number' => $validatedData['landline_number'] ?? null,
            'place_of_birth_municipality' => $validatedData['place_of_birth_municipality'] ?? null,
            'place_of_birth_province' => $validatedData['place_of_birth_province'] ?? null,
            'place_of_birth_country' => $validatedData['place_of_birth_country'] ?? null,
            'name_of_spouse' => $validatedData['name_of_spouse'] ?? null,
            'household_head' => $validatedData['household_head'] ?? false,
            'name_of_household_head' => $validatedData['name_of_household_head'] ?? null,
            'relationship_with_household_head' => $validatedData['relationship_with_household_head'] ?? null,
            'no_of_living_household_members' => $validatedData['no_of_living_household_members'] ?? 0,
            'no_of_male' => $validatedData['no_of_male'] ?? 0,
            'no_of_female' => $validatedData['no_of_female'] ?? 0,
            'highest_formal_education' => $validatedData['highest_formal_education'] ?? null,
            'is_pwd' => $validatedData['is_pwd'] ?? false,
            'is_4ps_beneficiary' => $validatedData['is_4ps_beneficiary'] ?? false,
            'is_indigenous_group_member' => $validatedData['is_indigenous_group_member'] ?? false,
            'indigenous_group_name' => $validatedData['indigenous_group_name'] ?? null,
            'has_government_id' => $validatedData['has_government_id'] ?? false,
            'id_type' => $validatedData['id_type'] ?? null,
            'id_number' => $validatedData['id_number'] ?? null,
            'is_farmers_association_member' => $validatedData['is_farmers_association_member'] ?? false,
            'farmers_association_name' => $validatedData['farmers_association_name'] ?? null,
            'emergency_contact_name' => $validatedData['emergency_contact_name'] ?? null,
            'emergency_contact_number' => $validatedData['emergency_contact_number'] ?? null,
            'main_livelihood' => $validatedData['main_livelihood'] ?? [],
            'farming_rice' => $validatedData['farming_rice'] ?? false,
            'farming_corn' => $validatedData['farming_corn'] ?? false,
            'other_crops' => $validatedData['other_crops'] ?? false,
            'farming_other_crops' => $validatedData['farming_other_crops'] ?? null,
            'livestock' => $validatedData['livestock'] ?? false,
            'farming_livestock' => $validatedData['farming_livestock'] ?? null,
            'poultry' => $validatedData['poultry'] ?? false,
            'farming_poultry' => $validatedData['farming_poultry'] ?? null,
            'work_land_preparation' => $validatedData['work_land_preparation'] ?? false,
            'work_planting_transplanting' => $validatedData['work_planting_transplanting'] ?? false,
            'work_cultivation' => $validatedData['work_cultivation'] ?? false,
            'work_harvesting' => $validatedData['work_harvesting'] ?? false,
            'work_others' => $validatedData['work_others'] ?? false,
            'work_others_specify' => $validatedData['work_others_specify'] ?? null,
            'fishing_fish_capture' => $validatedData['fishing_fish_capture'] ?? false,
            'fishing_aquaculture' => $validatedData['fishing_aquaculture'] ?? false,
            'fishing_gleaning' => $validatedData['fishing_gleaning'] ?? false,
            'fishing_fish_processing' => $validatedData['fishing_fish_processing'] ?? false,
            'fishing_fish_vending' => $validatedData['fishing_fish_vending'] ?? false,
            'fishing_others' => $validatedData['fishing_others'] ?? false,
            'fishing_others_specify' => $validatedData['fishing_others_specify'] ?? null,
            'youth_farming_household' => $validatedData['youth_farming_household'] ?? false,
            'youth_agri_course' => $validatedData['youth_agri_course'] ?? false,
            'youth_nonformal_agri_course' => $validatedData['youth_nonformal_agri_course'] ?? false,
            'youth_agri_program' => $validatedData['youth_agri_program'] ?? false,
            'youth_others' => $validatedData['youth_others'] ?? false,
            'youth_others_specify' => $validatedData['youth_others_specify'] ?? null,
            'gross_annual_income_farming' => $validatedData['gross_annual_income_farming'] ?? null,
            'gross_annual_income_nonfarming' => $validatedData['gross_annual_income_nonfarming'] ?? null,
        ];

        // dd($rsbsaData);

        // Create an RsbsaRecord with validated data
        $twoByTwo['two_by_two'] = $validatedData['two_by_two'];
        unset($validatedData['two_by_two']); 

        $rsbsaRecord = RsbsaRecord::create($rsbsaData);
        
        if ($twoByTwo['two_by_two']) {
            $rsbsaRecord->addMedia(collect($twoByTwo['two_by_two'])->first())->toMediaCollection('two_by_two');
        }


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
    //   dd($this->member->user);
    $this->form->fill([
        'darbc_id'=> $this->member->darbc_id,
        'member_information_id'=> $this->member->id,
        'user_id'=> $this->member->user_id,
        'surname'=> $this->member->user?->surname,
        'first_name'=> $this->member->user?->first_name,
        'middle_name'=> $this->member->user?->middle_name,
        'gender'=> $this->member?->gender->name,
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
