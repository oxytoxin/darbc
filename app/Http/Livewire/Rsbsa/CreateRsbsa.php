<?php

namespace App\Http\Livewire\Rsbsa;

use Livewire\Component;

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
use Filament\Forms\Components\Fieldset;
use App\Forms\Components\VerticalWizard;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Wizard\Step;
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
        return [
            Wizard::make([
                // Step 1: Personal Information
                Step::make('Part I: Personal Information')
                    ->description('Provide your personal details.')
                    ->schema([
                        Fieldset::make('DARBC DETAILS')->columns(2)->schema([
                            TextInput::make('darbc_id')->required(),
                            TextInput::make('member_information_id')->required(),
                            TextInput::make('user_id')->required(),
                           
                        ]),
                        Fieldset::make('Personal Details')->columns(2)->schema([
                            TextInput::make('surname')->required(),
                            TextInput::make('first_name')->required(),
                            TextInput::make('middle_name'),
                            TextInput::make('extension_name'),
                            Select::make('sex')->options(['Male' => 'Male', 'Female' => 'Female'])->nullable(),
                            DatePicker::make('date_of_birth')->required(),
                            TextInput::make('mobile_number')->label('Mobile Number'),
                            TextInput::make('landline_number')->label('Landline'),
                        ]),

                        Fieldset::make('Address Information')->columns(2)->columnSpanFull()->schema([
                            TextInput::make('house_lot_bldg_purok')->label('House Lot/Purok'),
                            TextInput::make('street_sitio_subdv')->label('Street/Sitio/Subdivision'),
                            TextInput::make('barangay'),
                            TextInput::make('city_municipality'),
                            TextInput::make('province'),
                            TextInput::make('region'),
                        ]),

                        Fieldset::make('Birth & Civil Status')->columns(2)->columnSpanFull()->schema([
                            TextInput::make('place_of_birth_municipality')->label('Birth Municipality'),
                            TextInput::make('place_of_birth_province')->label('Birth Province'),
                            TextInput::make('place_of_birth_country')->label('Birth Country'),
                            Select::make('civil_status')->options([
                                'Single' => 'Single', 'Married' => 'Married', 'Widowed' => 'Widowed', 'Separated' => 'Separated'
                            ]),
                            TextInput::make('religion'),
                            TextInput::make('name_of_spouse'),
                            TextInput::make('mother_maiden_name'),
                        ]),

                        Fieldset::make('Household Information')->columns(2)->columnSpanFull()->schema([
                            Toggle::make('household_head')->label('Are you the Household Head?'),
                            TextInput::make('name_of_household_head')->label('Household Head Name'),
                            TextInput::make('relationship_with_household_head'),
                            TextInput::make('no_of_living_household_members')->numeric(),
                            TextInput::make('no_of_male')->numeric(),
                            TextInput::make('no_of_female')->numeric(),
                        ]),

                        Fieldset::make('Education & Status')->columns(2)->columnSpanFull()->schema([
                            Select::make('highest_formal_education')->options([
                                'None' => 'None', 'Elementary' => 'Elementary', 'High School' => 'High School',
                                'College' => 'College', 'Vocational' => 'Vocational'
                            ]),
                            Toggle::make('is_pwd')->label('Are you a PWD?'),
                            Toggle::make('is_4ps_beneficiary')->label('Are you a 4Ps Beneficiary?'),
                            Toggle::make('is_indigenous_group_member')->label('Are you part of an indigenous group?'),
                            TextInput::make('indigenous_group_name')->label('Indigenous Group Name'),
                        ]),

                        Fieldset::make('Identification & Emergency')->columns(2)->columnSpanFull()->schema([
                            Toggle::make('has_government_id')->label('Do you have a Government ID?'),
                            TextInput::make('id_type')->label('ID Type'),
                            TextInput::make('id_number')->label('ID Number'),
                            Toggle::make('is_farmers_association_member')->label('Are you a Farmers Association Member?'),
                            TextInput::make('farmers_association_name')->label('Farmers Association Name'),
                            TextInput::make('emergency_contact_name')->label('Emergency Contact Name')->required(),
                            TextInput::make('emergency_contact_number')->label('Emergency Contact Number')->required(),
                        ]),
                    ]),

                // Step 2: Farm Profile
                Step::make('Part II: Farm Profile')
                    ->description('Provide details of your farming activities.')
                    ->schema([
                        Fieldset::make('Livelihood Type')->schema([
                            Select::make('main_livelihood')
                                ->label('Main Livelihood')
                                ->options(['Farmer' => 'Farmer', 'Farmworker/Laborer' => 'Farmworker/Laborer', 'Fisherfolk' => 'Fisherfolk', 'Agri Youth' => 'Agri Youth'])
                                ->required(),
                        ]),

                        Fieldset::make('Farming Activities')->columns(2)->columnSpanFull()->schema([
                            Toggle::make('farming_rice')->label('Farming Rice'),
                            Toggle::make('farming_corn')->label('Farming Corn'),
                            TextInput::make('farming_other_crops')->label('Other Crops'),
                            TextInput::make('farming_livestock')->label('Livestock'),
                            TextInput::make('farming_poultry')->label('Poultry'),
                        ]),

                        Fieldset::make('Farmworker Tasks')->columns(2)->columnSpanFull()->schema([
                            Toggle::make('work_land_preparation'),
                            Toggle::make('work_planting_transplanting'),
                            Toggle::make('work_cultivation'),
                            Toggle::make('work_harvesting'),
                            TextInput::make('work_others'),
                        ]),

                        Fieldset::make('Fisherfolk Activities')->columns(2)->columnSpanFull()->schema([
                            Toggle::make('fishing_fish_capture'),
                            Toggle::make('fishing_aquaculture'),
                            Toggle::make('fishing_gleaning'),
                            Toggle::make('fishing_fish_processing'),
                            Toggle::make('fishing_fish_vending'),
                            TextInput::make('fishing_others'),
                        ]),

                        Fieldset::make('Agri Youth Involvement')->columns(2)->columnSpanFull()->schema([
                            Toggle::make('youth_farming_household'),
                            Toggle::make('youth_agri_course'),
                            Toggle::make('youth_nonformal_agri_course'),
                            Toggle::make('youth_agri_program'),
                            TextInput::make('youth_others'),
                        ]),
                    ]),

                // Step 3: Income Details
                Step::make('Income Details')
                    ->description('Provide details of your annual income.')
                    ->schema([
                        Fieldset::make('Annual Income')->columns(2)->schema([
                            TextInput::make('gross_annual_income_farming')->numeric()->prefix('₱'),
                            TextInput::make('gross_annual_income_nonfarming')->numeric()->prefix('₱'),
                        ]),
                    ]),
               
            ])
            ->submitAction(new HtmlString('<button class="p-1 px-2 text-sm font-semibold text-white rounded bg-primary-500" wire:click="register">Finish <span wire:loading class="animate-bounce">...</span></button>'))
        ];
    }

 
    public function register()
    {

        dd($this->data);
        // try {
        //     $this->form->validate();
        // } catch (\Throwable $th) {
        //     notify(title: $th->getMessage(), type: 'danger');
        //     throw $th;
        // }

        // DB::beginTransaction();
        // DB::commit();
        // Notification::make()->title('Member successfully registered.')->success()->send();
        // $this->redirect($this->getRedirectionRoute());
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
        $this->form->fill();
        // $this->form->fill();
    }
    public function render()
    {
        return view('livewire.rsbsa.create-rsbsa');
    }
}
