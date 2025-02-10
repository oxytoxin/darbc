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
        return [
            Wizard::make([
                // Step 1: Personal Information
                // Step::make('Header Section')
                //     ->schema([

                //         Fieldset::make('Reference Number')->columns(4)->schema([
                //             // TextInput::make('reference_number')->required(),
                //             TextInput::make('region_code')->required()->mask(fn (TextInput\Mask $mask) => $mask->pattern('00'))
                //             ->label('Region')->placeholder('00'),
                //             TextInput::make('province_code')->required()->mask(fn (TextInput\Mask $mask) => $mask->pattern('00'))
                //             ->label('Province')->placeholder('00')
                //             ,
                //             TextInput::make('city_municipality_code')->required()->mask(fn (TextInput\Mask $mask) => $mask->pattern('00'))
                //             ->label('City/Muni')->placeholder('00')
                //             ,
                //             TextInput::make('barangay_code')->required()->mask(fn (TextInput\Mask $mask) => $mask->pattern('000000'))
                //             ->label('Barangay')->placeholder('000000')
                //             ,
                           
                //         ]),
                //     ]),
                Step::make('Part I: Personal Information')
                    ->description('Provide your personal details.')
                    ->schema([

                        

                        Fieldset::make('DARBC DETAILS')->columns(2)->schema([

                            TextInput::make('darbc_id')->required()->label('DARBC ID')->disabled(),
                            
                           
                        ]),
                        Fieldset::make('Personal Details')->columns(2)->schema([
                            FileUpload::make('two_by_two')->avatar()->label('2x2 Picture')->columnSpanFull(),
                            TextInput::make('surname')->required()->disabled()->hint('(Editable in Profiling)'),
                            TextInput::make('first_name')->required()->disabled()->hint('(Editable in Profiling)'),
                            TextInput::make('middle_name')->required()->disabled()->hint('(Editable in Profiling)'),
                            TextInput::make('extension_name')
                            ->label('Extension Name')
                          
                            ->helperText('Example: "Jr.", "Sr.", "III", "IV" (Leave blank if not applicable)'),
                            //->hint('Suffix such as Jr., Sr., III, IV (optional)'),
                        
                            TextInput::make('gender')->required()->disabled()->hint('(Editable in Profiling)'),
                          
                            DatePicker::make('date_of_birth')->required()->disabled()->hint('(Editable in Profiling)'),
                            TextInput::make('contact_number')->required()->label('Mobile Number')->disabled(),
                            TextInput::make('landline_number')->label('Landline'),
                        ]),

                        Fieldset::make('Address Information')->columns(3)->columnSpanFull()->schema([
                            TextInput::make('house_lot_bldg_purok')->required()->label('House Lot/Purok')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                            TextInput::make('street_sitio_subdv')->required()->label('Street/Sitio/Subdivision')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                            // Select::make('data.address.region')
                            // ->reactive()
                            // ->options(Region::pluck('description', 'code')),
                        // Select::make('data.address.province')
                        //     ->reactive()
                        //     ->visible(fn ($get) => $get(('data.address.region')))
                        //     ->options(fn ($get) => Province::when($get('data.address.region'), fn ($q) => $q->whereRegionCode($get('data.address.region')))->pluck('description', 'code')),
                        // Select::make('data.address.city')
                        //     ->reactive()
                        //     ->visible(fn ($get) => $get(('data.address.province')))
                        //     ->options(fn ($get) => City::when($get('data.address.province'), fn ($q) => $q->whereProvinceCode($get('data.address.province')))->pluck('description', 'code')),
                        // Select::make('data.address.barangay')
                        //     ->reactive()
                        //     ->visible(fn ($get) => $get(('data.address.city')))
                        //     ->options(fn ($get) => Barangay::when($get('data.address.city'), fn ($q) => $q->whereCityCode($get('data.address.city')))->pluck('description', 'code')),
                            TextInput::make('barangay')->required()->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                            TextInput::make('city_municipality')->required()->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                            TextInput::make('province')->required()->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                            TextInput::make('region')->required()->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                        ]),

                        Fieldset::make('Birth & Civil Status')->columns(2)->columnSpanFull()->schema([
                            TextInput::make('place_of_birth_municipality')->label('Municipality')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                            TextInput::make('place_of_birth_province')->label('Province/State')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                            TextInput::make('place_of_birth_country')->label('Country')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                            Select::make('civil_status')
                            ->options([
                                MemberInformation::CS_SINGLE => 'Single',
                                MemberInformation::CS_MARRIED => 'Married',
                                MemberInformation::CS_WIDOW => 'Widow',
                                MemberInformation::CS_LEGALLY_SEPARATED => 'Legally Separated',
                                MemberInformation::CS_UNKNOWN => 'Unknown',
                            ])
                            ->disabled()->required()->hint('(Editable in Profiling)')
                            ->required()
                            ->default(MemberInformation::CS_SINGLE),
                            TextInput::make('religion')->disabled()->hint('(Editable in Profiling)'),
                            TextInput::make('name_of_spouse') ->disabled()->hint('(Editable in Profiling)'),
                            TextInput::make('mother_maiden_name')->disabled()->hint('(Editable in Profiling)'),
                        ]),

                        Fieldset::make('Household Information')->columns(3)->columnSpanFull()->schema([
                            Checkbox::make('household_head')->label('Household Head?')
                            ->columnSpanFull()
                            ->helperText('check this if you are the head of your household.')
                            ->reactive()
                            
                            
                            ,
                            TextInput::make('name_of_household_head')->label('Household Head Name')->hidden(fn (Closure $get) => $get('household_head'))->columnSpanFull(),
                            
                            TextInput::make('relationship_with_household_head')->hidden(fn (Closure $get) => $get('household_head'))->columnSpanFull(),
                            TextInput::make('no_of_living_household_members')->mask(fn (TextInput\Mask $mask) => $mask->pattern('00'))->label('No. of living household members'),
                            TextInput::make('no_of_male')->mask(fn (TextInput\Mask $mask) => $mask->pattern('00'))->label('No. of male'),
                            TextInput::make('no_of_female')->mask(fn (TextInput\Mask $mask) => $mask->pattern('00'))->label('No. of female'),
                        ]),

                        Fieldset::make('Education & Status')->columns(2)->columnSpanFull()->schema([
                            Select::make('highest_formal_education')->options(RsbsaRecord::HIGHEST_FORMAL_EDUCATION)->columnSpanFull()->required(),
                            Checkbox::make('is_pwd')->label('Person with disability?')->columnSpanFull(),
                            Checkbox::make('is_4ps_beneficiary')
                            ->label('4Ps Beneficiary?')
                            ->columnSpanFull(),
                        
                        Checkbox::make('is_indigenous_group_member')
                            ->label('Member of an indigenous group?')
                            ->reactive()
                            // ->helperText('Check this if you are a member of an indigenous group.')
                            ->columnSpanFull(),
                        
                            TextInput::make('indigenous_group_name')->label('Indigenous Group Name')->columnSpanFull()->hidden(fn (Closure $get) => !$get('is_indigenous_group_member')),
                        ]),

                        Fieldset::make('Identification & Emergency')->columns(2)->columnSpanFull()->schema([
                            Checkbox::make('has_government_id')->label('With Government ID?')->reactive()->columnSpanFull(),
                            TextInput::make('id_type')->label('ID Type')->hidden(fn (Closure $get) => !$get('has_government_id')),
                            TextInput::make('id_number')->label('ID Number')->hidden(fn (Closure $get) => !$get('has_government_id')),
                            Checkbox::make('is_farmers_association_member')->label('Are you a Farmers Association Member?')->reactive()->columnSpanFull(),
                            TextInput::make('farmers_association_name')->label('Farmers Association Name')->columnSpanFull()->hidden(fn (Closure $get) => !$get('is_farmers_association_member')),
                            TextInput::make('emergency_contact_name')->required()->label('Emergency Contact Name'),
                            TextInput::make('emergency_contact_number')->required()->label('Emergency Contact Number'),
                        ]),
                    ]),

                // Step 2: Farm Profile
                Step::make('Part II: Farm Profile')
                    ->description('Provide details of your farming activities.')
                    ->schema([
                        Fieldset::make('Livelihood Type')->schema([
                            // Select::make('main_livelihood')
                            // ->reactive()
                            // ->multiple()
                            // // ->afterStateUpdated(function (Closure $set, $state) {
                            // //     dd($state);
                            // // })
                            CheckboxList::make('main_livelihood')
                            ->required()
                            ->reactive()
                            ->helperText('Select all applicable sources of livelihood.')
                            ->label('MAIN LIVELIHOOD')
    ->options(RsbsaRecord::LIVELIHOOD_OPTION)
    ->columns(4)
                                ->label('Main Livelihood')
                                ->options(RsbsaRecord::LIVELIHOOD_OPTION)
                                ->required(),
                           
                        ]),

                        Fieldset::make('Farming Activities')->columns(2)->columnSpanFull()->schema([
                            Checkbox::make('farming_rice')
                            ->label('Rice Farming')
                            ->columnSpanFull()
                           
                            ,
                        
                        Checkbox::make('farming_corn')
                            ->label('Corn Farming')
                            ->columnSpanFull(),
                        
                        Checkbox::make('other_crops')
                            ->label('Other Crops')
                            ->columnSpanFull()
                            ->reactive(),
                        
                        TextInput::make('farming_other_crops')
                            ->label('Specify Other Crops')
                            ->hidden(fn (Closure $get) => !$get('other_crops')),
                        
                        Checkbox::make('livestock')
                            ->label('Livestock ')
                            ->columnSpanFull()
                            ->reactive(),
                        
                        TextInput::make('farming_livestock')
                            ->label('Specify Livestock')
                            ->hidden(fn (Closure $get) => !$get('livestock')),
                        
                        Checkbox::make('poultry')
                            ->label('Poultry ')
                            ->columnSpanFull()
                            ->reactive(),
                        
                        TextInput::make('farming_poultry')
                            ->label('Specify Poultry')
                            ->hidden(fn (Closure $get) => !$get('poultry')),
                        
                            
                        ])
                        // ->hidden(fn (Closure $get) => $get('main_livelihood') != 'Farmer')
                        ->hidden(fn (Closure $get) => !in_array('Farmer', $get('main_livelihood') ?? [])), 
                        

                        Fieldset::make('Farmworker Kind of work')->columns(2)->columnSpanFull()->schema([
                            Checkbox::make('work_land_preparation') ->columnSpanFull()->label('Land Preparation'),
                            Checkbox::make('work_planting_transplanting') ->columnSpanFull()->label('Planting/Transplanting'),
                            Checkbox::make('work_cultivation') ->columnSpanFull()->label('Cultivation'),
                            Checkbox::make('work_harvesting') ->columnSpanFull()->label('Harvesting'),
                            Checkbox::make('work_others') ->columnSpanFull()->reactive()->label('Other'),
                            TextInput::make('work_others_specify')->columnSpanFull()->hidden(fn (Closure $get) => !$get('work_others'))->label('Please Specify other work'),
                        ])
                        // ->hidden(fn (Closure $get) => $get('main_livelihood') != 'Farmworker/Laborer')
                        ->hidden(fn (Closure $get) => !in_array('Farmworker/Laborer', $get('main_livelihood') ?? [])), 
                        

                        Fieldset::make('Fisherfolk Activities')
    ->columns(2)
    ->columnSpanFull()
    ->schema([
        Checkbox::make('fishing_fish_capture')
            ->columnSpanFull()
            ->label('Fish Capture'),

        Checkbox::make('fishing_aquaculture')
            ->columnSpanFull()
            ->label('Aquaculture'),

        Checkbox::make('fishing_gleaning')
            ->columnSpanFull()
            ->label('Gleaning'),

        Checkbox::make('fishing_fish_processing')
            ->columnSpanFull()
            ->label('Fish Processing'),

        Checkbox::make('fishing_fish_vending')
            ->columnSpanFull()
            ->label('Fish Vending'),

        Checkbox::make('fishing_others')
        ->reactive()
            ->columnSpanFull()
            ->label('Other'),

        TextInput::make('fishing_others_specify')
            ->columnSpanFull()
            ->hidden(fn (Closure $get) => !$get('fishing_others'))
            ->label('Specify Other Fishing Activity'),
    ])

                        // ->hidden(fn (Closure $get) => $get('main_livelihood') != 'Fisherfolk')
                        ->hidden(fn (Closure $get) => !in_array('Fisherfolk', $get('main_livelihood') ?? [])), 
                        

                        Fieldset::make('Agri Youth Involvement')
    ->columns(2)
    ->columnSpanFull()
    ->schema([
        Checkbox::make('youth_farming_household')
            ->label('Involved in Household Farming')
            ->columnSpanFull(),

        Checkbox::make('youth_agri_course')
            ->label('Taken Agricultural Course')
            ->columnSpanFull(),

        Checkbox::make('youth_nonformal_agri_course')
            ->label('Taken Non-Formal Agri Course')
            ->columnSpanFull(),

        Checkbox::make('youth_agri_program')
            ->label('Participated in Agri Program')
            ->columnSpanFull(),

        Checkbox::make('youth_others')
            ->label('Other Involvement')
            ->reactive()
            ->columnSpanFull(), // Dynamically controls text input visibility

        TextInput::make('work_others_specify')
            ->label('Specify Other Involvement')
            ->columnSpanFull()
            ->hidden(fn (Closure $get) => !$get('youth_others')), // Only shows if 'Others' is checked
    ])  ->hidden(fn (Closure $get) => !in_array('Agri Youth', $get('main_livelihood') ?? [])), 


    Fieldset::make('Annual Income')->columns(2)->schema([
        TextInput::make('gross_annual_income_farming')->numeric()->prefix('₱'),
        TextInput::make('gross_annual_income_nonfarming')->numeric()->prefix('₱'),
    ]),

                    ]),

                // Step 3: Income Details
                // Step::make('Income Details')
                //     ->description('Provide details of your annual income.')
                //     ->schema([
                      
                //     ]),
               
            ])
            // ->startOnStep(2)
            ->submitAction(new HtmlString('<button class="p-1 px-2 text-sm font-semibold text-white rounded bg-primary-500" wire:click="register">Finish <span wire:loading class="animate-bounce">...</span></button>'))
        ];
    }


 
    public function register()
{
    DB::beginTransaction();

    try {
        // Validate the form data using Filament's form validation
        $validatedData = $this->form->validate();

        // Create an RsbsaRecord with validated data
        $rsbsaRecord = RsbsaRecord::create([
            'darbc_id' => $validatedData['darbc_id'],
            'member_information_id' => $validatedData['member_information_id'],
            'user_id' => $validatedData['user_id'],
            'enrollment_type' => $validatedData['enrollment_type'],
            'reference_number' => $validatedData['reference_number'] ?? null,
            'region_code' => $validatedData['region_code'],
            'province_code' => $validatedData['province_code'],
            'city_municipality_code' => $validatedData['city_municipality_code'],
            'barangay_code' => $validatedData['barangay_code'],
            'surname' => $validatedData['surname'],
            'middle_name' => $validatedData['middle_name'],
            'first_name' => $validatedData['first_name'],
            'extension_name' => $validatedData['extension_name'],
            'sex' => $validatedData['gender'],
            'house_lot_bldg_purok' => $validatedData['house_lot_bldg_purok'],
            'street_sitio_subdv' => $validatedData['street_sitio_subdv'],
            'barangay' => $validatedData['barangay'],
            'city_municipality' => $validatedData['city_municipality'],
            'province' => $validatedData['province'],
            'region' => $validatedData['region'],
            'contact_number' => $validatedData['contact_number'],
            'landline_number' => $validatedData['landline_number'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'place_of_birth_municipality' => $validatedData['place_of_birth_municipality'],
            'place_of_birth_province' => $validatedData['place_of_birth_province'],
            'place_of_birth_country' => $validatedData['place_of_birth_country'],
            'religion' => $validatedData['religion'],
            'civil_status' => $validatedData['civil_status'],
            'name_of_spouse' => $validatedData['name_of_spouse'],
            'mother_maiden_name' => $validatedData['mother_maiden_name'],
            'household_head' => $validatedData['household_head'] ?? false,
            'name_of_household_head' => $validatedData['name_of_household_head'],
            'relationship_with_household_head' => $validatedData['relationship_with_household_head'],
            'no_of_living_household_members' => $validatedData['no_of_living_household_members'],
            'no_of_male' => $validatedData['no_of_male'],
            'no_of_female' => $validatedData['no_of_female'],
            'highest_formal_education' => $validatedData['highest_formal_education'],
            'is_pwd' => $validatedData['is_pwd'] ?? false,
            'is_4ps_beneficiary' => $validatedData['is_4ps_beneficiary'] ?? false,
            'is_indigenous_group_member' => $validatedData['is_indigenous_group_member'] ?? false,
            'indigenous_group_name' => $validatedData['indigenous_group_name'],
            'has_government_id' => $validatedData['has_government_id'] ?? false,
            'id_type' => $validatedData['id_type'],
            'id_number' => $validatedData['id_number'],
            'is_farmers_association_member' => $validatedData['is_farmers_association_member'] ?? false,
            'farmers_association_name' => $validatedData['farmers_association_name'],
            'emergency_contact_name' => $validatedData['emergency_contact_name'],
            'emergency_contact_number' => $validatedData['emergency_contact_number'],
            'main_livelihood' => $validatedData['main_livelihood'],
            'farming_rice' => $validatedData['farming_rice'] ?? false,
            'farming_corn' => $validatedData['farming_corn'] ?? false,
            'other_crops' => $validatedData['other_crops'] ?? false,
            'farming_other_crops' => $validatedData['farming_other_crops'],
            'livestock' => $validatedData['livestock'] ?? false,
            'farming_livestock' => $validatedData['farming_livestock'],
            'poultry' => $validatedData['poultry'] ?? false,
            'farming_poultry' => $validatedData['farming_poultry'],
            'work_land_preparation' => $validatedData['work_land_preparation'] ?? false,
            'work_planting_transplanting' => $validatedData['work_planting_transplanting'] ?? false,
            'work_cultivation' => $validatedData['work_cultivation'] ?? false,
            'work_harvesting' => $validatedData['work_harvesting'] ?? false,
            'work_others' => $validatedData['work_others'] ?? false,
            'work_others_specify' => $validatedData['work_others_specify'],
            'fishing_fish_capture' => $validatedData['fishing_fish_capture'] ?? false,
            'fishing_aquaculture' => $validatedData['fishing_aquaculture'] ?? false,
            'fishing_gleaning' => $validatedData['fishing_gleaning'] ?? false,
            'fishing_fish_processing' => $validatedData['fishing_fish_processing'] ?? false,
            'fishing_fish_vending' => $validatedData['fishing_fish_vending'] ?? false,
            'fishing_others' => $validatedData['fishing_others'] ?? false,
            'fishing_others_specify' => $validatedData['fishing_others_specify'],
            'youth_farming_household' => $validatedData['youth_farming_household'] ?? false,
            'youth_agri_course' => $validatedData['youth_agri_course'] ?? false,
            'youth_nonformal_agri_course' => $validatedData['youth_nonformal_agri_course'] ?? false,
            'youth_agri_program' => $validatedData['youth_agri_program'] ?? false,
            'youth_others' => $validatedData['youth_others'] ?? false,
            'youth_others_specify' => $validatedData['youth_others_specify'],
            'gross_annual_income_farming' => $validatedData['gross_annual_income_farming'],
            'gross_annual_income_nonfarming' => $validatedData['gross_annual_income_nonfarming'],
        ]);

        // Attach media (two_by_two photo)
        if (isset($validatedData['two_by_two']) && $validatedData['two_by_two']) {
            $rsbsaRecord
                ->addMedia($validatedData['two_by_two'])
                ->toMediaCollection('two_by_two');
        }

        DB::commit();

        // Notify success
        Notification::make()
            ->title('Success!')
            ->body('The RSBSA record has been successfully created.')
            ->success()
            ->send();

        // Redirect or reset form
        return redirect()->route('your.redirect.route'); // Replace with your actual route
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
