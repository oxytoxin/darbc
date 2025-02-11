<?php

namespace App\Http\Controllers\Rsbase;

use Closure;
use App\Models\City;
use App\Models\Region;
use App\Models\Barangay;
use App\Models\Province;
use App\Models\RsbsaRecord;
use Illuminate\Http\Request;
use App\Models\MemberInformation;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use App\Http\Controllers\Controller;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use App\Forms\Components\VerticalWizard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\MarkdownEditor;

class RsbsaFroms extends Controller
{
    public static function createForm(?RsbsaRecord $rsbsa = null): array
    {
        return [
            Wizard::make(self::formFields())
                // ->startOnStep(2)
                ->skippable()
                ->submitAction(new HtmlString('<button class="p-1 px-2 text-sm font-semibold text-white rounded bg-primary-500" wire:click="register">Finish <span wire:loading class="animate-bounce">...</span></button>'))
        ];
    }
    public static function editForm(RsbsaRecord $rsbsa): array
    {
        return [
            Wizard::make(self::formFields($rsbsa))
                // ->startOnStep(2)
                ->skippable()
                ->submitAction(new HtmlString('<button class="p-1 px-2 text-sm font-semibold text-white rounded bg-primary-500" wire:click="update">Update <span wire:loading class="animate-bounce">...</span></button>'))
        ];
    }


    public static function formFields(?RsbsaRecord $rsbsa = null): array
    {

        return [

            Step::make('Header Section')
                ->schema([

                    Fieldset::make('Reference Number')->columns(4)->schema([
                        // TextInput::make('reference_number')->required(),
                        TextInput::make('region_code')->required()->mask(fn(TextInput\Mask $mask) => $mask->pattern('00'))
                            ->label('Region')->placeholder('00'),
                        TextInput::make('province_code')->required()->mask(fn(TextInput\Mask $mask) => $mask->pattern('00'))
                            ->label('Province')->placeholder('00'),
                        TextInput::make('city_municipality_code')->required()->mask(fn(TextInput\Mask $mask) => $mask->pattern('00'))
                            ->label('City/Muni')->placeholder('00'),
                        TextInput::make('barangay_code')->required()->mask(fn(TextInput\Mask $mask) => $mask->pattern('000000'))
                            ->label('Barangay')->placeholder('000000'),

                    ]),
                ]),
            Step::make('Part I: Personal Information')
                ->description('Provide your personal details.')
                ->schema([



                    Fieldset::make('DARBC DETAILS')->columns(2)->schema([


                        TextInput::make('darbc_id')->required()->label('DARBC ID')->disabled(),


                    ]),
                    Fieldset::make('Personal Details')->schema([
                        Fieldset::make('2x2 Picture')
                            ->schema([
                                Placeholder::make('photo')
                                    ->hidden(fn() => !request()->routeIs('rsbsa.edit')) // Hide in create mode
                                    ->disableLabel()
                                    ->content(fn() => new HtmlString('<img src="' . $rsbsa->getImage() .
                                        '" class="rounded-full w-32 h-32">')),


                                FileUpload::make('two_by_two')->avatar()->label('2x2 Picture'),

                            ])
                            ->maxWidth('sm')
                            ,
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
                        TextInput::make('name_of_spouse')->disabled()->hint('(Editable in Profiling)'),
                        TextInput::make('mother_maiden_name')->disabled()->hint('(Editable in Profiling)'),
                    ]),

                    Fieldset::make('Household Information')->columns(3)->columnSpanFull()->schema([
                        Checkbox::make('household_head')->label('Household Head?')
                            ->columnSpanFull()
                            ->helperText('check this if you are the head of your household.')
                            ->reactive(),
                        TextInput::make('name_of_household_head')->label('Household Head Name')->hidden(fn(Closure $get) => $get('household_head'))->columnSpanFull()->required(),

                        TextInput::make('relationship_with_household_head')->hidden(fn(Closure $get) => $get('household_head'))->columnSpanFull(),
                        TextInput::make('no_of_living_household_members')->mask(fn(TextInput\Mask $mask) => $mask->pattern('00'))->label('No. of living household members'),
                        TextInput::make('no_of_male')->mask(fn(TextInput\Mask $mask) => $mask->pattern('00'))->label('No. of male'),
                        TextInput::make('no_of_female')->mask(fn(TextInput\Mask $mask) => $mask->pattern('00'))->label('No. of female'),
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

                        TextInput::make('indigenous_group_name')
                            ->required()
                            ->label('Indigenous Group Name')->columnSpanFull()->hidden(fn(Closure $get) => !$get('is_indigenous_group_member')),
                    ]),

                    Fieldset::make('Identification & Emergency')->columns(2)->columnSpanFull()->schema([
                        Checkbox::make('has_government_id')->label('With Government ID?')->reactive()->columnSpanFull(),
                        TextInput::make('id_type')->label('ID Type')
                            ->required()
                            ->hidden(fn(Closure $get) => !$get('has_government_id')),
                        TextInput::make('id_number')->label('ID Number')
                            ->required()

                            ->hidden(fn(Closure $get) => !$get('has_government_id')),
                        Checkbox::make('is_farmers_association_member')->label('Are you a Farmers Association Member?')->reactive()->columnSpanFull(),
                        TextInput::make('farmers_association_name')
                            ->required()
                            ->label('Farmers Association Name')->columnSpanFull()->hidden(fn(Closure $get) => !$get('is_farmers_association_member')),
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
                            ->columnSpanFull(),

                        Checkbox::make('farming_corn')
                            ->label('Corn Farming')
                            ->columnSpanFull(),

                        Checkbox::make('other_crops')
                            ->label('Other Crops')
                            ->columnSpanFull()
                            ->reactive(),

                        TextInput::make('farming_other_crops')
                            ->label('Specify Other Crops')
                            ->hidden(fn(Closure $get) => !$get('other_crops'))->required(),

                        Checkbox::make('livestock')
                            ->label('Livestock ')
                            ->columnSpanFull()
                            ->reactive(),

                        TextInput::make('farming_livestock')
                            ->label('Specify Livestock')
                            ->hidden(fn(Closure $get) => !$get('livestock'))->required(),

                        Checkbox::make('poultry')
                            ->label('Poultry ')
                            ->columnSpanFull()

                            ->reactive(),

                        TextInput::make('farming_poultry')
                            ->label('Specify Poultry')
                            ->required()
                            ->hidden(fn(Closure $get) => !$get('poultry')),


                    ])
                        // ->hidden(fn (Closure $get) => $get('main_livelihood') != 'Farmer')
                        ->hidden(fn(Closure $get) => !in_array('Farmer', $get('main_livelihood') ?? [])),


                    Fieldset::make('Farmworker Kind of work')->columns(2)->columnSpanFull()->schema([
                        Checkbox::make('work_land_preparation')->columnSpanFull()->label('Land Preparation'),
                        Checkbox::make('work_planting_transplanting')->columnSpanFull()->label('Planting/Transplanting'),
                        Checkbox::make('work_cultivation')->columnSpanFull()->label('Cultivation'),
                        Checkbox::make('work_harvesting')->columnSpanFull()->label('Harvesting'),
                        Checkbox::make('work_others')->columnSpanFull()->reactive()->label('Other'),
                        TextInput::make('work_others_specify')
                            ->required()
                            ->columnSpanFull()->hidden(fn(Closure $get) => !$get('work_others'))->label('Please Specify other work'),
                    ])
                        // ->hidden(fn (Closure $get) => $get('main_livelihood') != 'Farmworker/Laborer')
                        ->hidden(fn(Closure $get) => !in_array('Farmworker/Laborer', $get('main_livelihood') ?? [])),


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
                                ->required()
                                ->hidden(fn(Closure $get) => !$get('fishing_others'))
                                ->label('Specify Other Fishing Activity'),
                        ])

                        // ->hidden(fn (Closure $get) => $get('main_livelihood') != 'Fisherfolk')
                        ->hidden(fn(Closure $get) => !in_array('Fisherfolk', $get('main_livelihood') ?? [])),


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

                            TextInput::make('youth_others_specify')
                                ->label('Specify Other Involvement')
                                ->columnSpanFull()
                                ->required()
                                ->hidden(fn(Closure $get) => !$get('youth_others')), // Only shows if 'Others' is checked
                        ])->hidden(fn(Closure $get) => !in_array('Agri Youth', $get('main_livelihood') ?? [])),


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


        ];
    }
}
