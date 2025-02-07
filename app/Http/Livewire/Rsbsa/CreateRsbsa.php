<?php

namespace App\Http\Livewire\Rsbsa;

use Closure;

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
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use App\Forms\Components\VerticalWizard;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
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
                // Step::make('RSBSA')
                //     ->schema([

                //         Fieldset::make('DARBC DETAILS')->columns(4)->schema([
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
                            TextInput::make('surname')->required()->disabled()->hint('(Editable in Profiling)'),
                            TextInput::make('first_name')->required()->disabled()->hint('(Editable in Profiling)'),
                            TextInput::make('middle_name')->disabled()->hint('(Editable in Profiling)'),
                            TextInput::make('extension_name'),
                            TextInput::make('gender')->disabled()->hint('(Editable in Profiling)'),
                          
                            DatePicker::make('date_of_birth')->required()->disabled()->hint('(Editable in Profiling)'),
                            TextInput::make('contact_number')->label('Mobile Number')->disabled(),
                            TextInput::make('landline_number')->label('Landline'),
                        ]),

                        Fieldset::make('Address Information')->columns(3)->columnSpanFull()->schema([
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
                            Select::make('civil_status')
                            ->options([
                                MemberInformation::CS_SINGLE => 'Single',
                                MemberInformation::CS_MARRIED => 'Married',
                                MemberInformation::CS_WIDOW => 'Widow',
                                MemberInformation::CS_LEGALLY_SEPARATED => 'Legally Separated',
                                MemberInformation::CS_UNKNOWN => 'Unknown',
                            ])
                            ->disabled()->hint('(Editable in Profiling)')
                            ->required()
                            ->default(MemberInformation::CS_SINGLE),
                            TextInput::make('religion') ->disabled()->hint('(Editable in Profiling)'),
                            TextInput::make('name_of_spouse') ->disabled()->hint('(Editable in Profiling)'),
                            TextInput::make('mother_maiden_name') ->disabled()->hint('(Editable in Profiling)'),
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
                            Select::make('highest_formal_education')->options(RsbsaRecord::HIGHEST_FORMAL_EDUCATION)->columnSpanFull(),
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
                            TextInput::make('emergency_contact_name')->label('Emergency Contact Name'),
                            TextInput::make('emergency_contact_number')->label('Emergency Contact Number'),
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
                            // ->afterStateUpdated(function (Closure $set, $state) {
                            //     dd($state);
                            // })
                            //     ->label('Main Livelihood')
                            //     ->options(RsbsaRecord::LIVELIHOOD_OPTION)
                            //     ->required(),
                            CheckboxList::make('main_livelihood')
                            ->reactive()
                            ->helperText('Select all applicable sources of livelihood.')
                            ->label('MAIN LIVELIHOOD')
    ->options(RsbsaRecord::LIVELIHOOD_OPTION)
    ->columns(4)
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
            ->startOnStep(2)
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
