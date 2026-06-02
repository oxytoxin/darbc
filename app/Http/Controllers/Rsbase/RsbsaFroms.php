<?php

namespace App\Http\Controllers\Rsbase;

use Closure;
use App\Models\City;
use App\Models\Gender;
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
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
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
                        Select::make('region_code')
                            ->label('Region')
                            ->placeholder('Select Region')
                            ->options(fn () => Region::pluck('description', 'code')->toArray())
                            ->reactive()
                            ->afterStateUpdated(function (callable $set) {
                                $set('province_code', null);
                                $set('city_municipality_code', null);
                                $set('barangay_code', null);
                            })
                            ->searchable(),
                        Select::make('province_code')
                            ->label('Province')
                            ->placeholder('Select Province')
                            ->options(function (callable $get) {
                                $regionCode = $get('region_code');
                                if ($regionCode) {
                                    return Province::where('region_code', $regionCode)->pluck('description', 'code')->toArray();
                                }
                                return Province::pluck('description', 'code')->toArray();
                            })
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $set('city_municipality_code', null);
                                $set('barangay_code', null);
                                if ($state) {
                                    $province = Province::where('code', $state)->first();
                                    if ($province) {
                                        $set('region_code', $province->region_code);
                                    }
                                }
                            })
                            ->searchable(),
                        Select::make('city_municipality_code')
                            ->label('City/Muni')
                            ->placeholder('Select City/Municipality')
                            ->options(function (callable $get) {
                                $provinceCode = $get('province_code');
                                if ($provinceCode) {
                                    return City::where('province_code', $provinceCode)->pluck('description', 'code')->toArray();
                                }
                                return [];
                            })
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $set('barangay_code', null);
                                if ($state) {
                                    $city = City::where('code', $state)->first();
                                    if ($city) {
                                        $set('province_code', $city->province_code);
                                        $set('region_code', $city->region_code);
                                    }
                                }
                            })
                            ->searchable(),
                        Select::make('barangay_code')
                            ->label('Barangay')
                            ->placeholder('Select Barangay')
                            ->options(function (callable $get) {
                                $cityCode = $get('city_municipality_code');
                                if ($cityCode) {
                                    return Barangay::where('city_code', $cityCode)->pluck('description', 'code')->toArray();
                                }
                                // Don't load all 42k barangays - require city selection
                                return [];
                            })
                            ->searchable(),
                    ]),

                    Fieldset::make('Transaction Code')->columns(2)->schema([
                        Select::make('has_philid')
                            ->label('PhilSys Registration')
                            ->options([
                                1 => 'With PhilID / ePhilID (PCN)',
                                0 => 'No PhilID / ePhilID (TRN)',
                            ])
                            ->reactive()
                            ->columnSpanFull(),
                        TextInput::make('philsys_card_number')
                            ->label('PhilSys Card Number (PCN)')
                            ->hidden(fn (Closure $get) => (string) $get('has_philid') !== '1'),
                        TextInput::make('transaction_reference_number')
                            ->label('Transaction Reference Number (TRN)')
                            ->hidden(fn (Closure $get) => (string) $get('has_philid') !== '0'),
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
                        TextInput::make('surname')->hint('(Editable in Profiling)'),
                        TextInput::make('first_name')->hint('(Editable in Profiling)'),
                        TextInput::make('middle_name')->hint('(Editable in Profiling)'),
                        Checkbox::make('no_middle_name')->label('No Middle Name'),
                        TextInput::make('extension_name')
                            ->label('Extension Name')

                            ->helperText('Example: "Jr.", "Sr.", "III", "IV" (Leave blank if not applicable)'),
                        Checkbox::make('no_extension_name')->label('No Extension Name'),
                        //->hint('Suffix such as Jr., Sr., III, IV (optional)'),

                        Select::make('gender_id')

                        ->label('Gender')
                        // ->required()
                        ->default(Gender::UNKNOWN)
                        ->disablePlaceholderSelection()
                        ->options(Gender::all()->pluck('name', 'id')),

                        DatePicker::make('date_of_birth')->hint('(Editable in Profiling)'),
                        TextInput::make('contact_number')->label('Mobile Number'),
                        Checkbox::make('owns_mobile_number')
                            ->label('Do you own the mobile number above?')
                            ->default(true)
                            ->reactive()
                            ->columnSpanFull(),
                        TextInput::make('mobile_owner_name')
                            ->label('Full Name of Mobile Number Owner')
                            ->hidden(fn (Closure $get) => (bool) $get('owns_mobile_number')),
                        TextInput::make('mobile_owner_relationship')
                            ->label('Relationship with Owner')
                            ->hidden(fn (Closure $get) => (bool) $get('owns_mobile_number')),
                        TextInput::make('landline_number')
                            ->label('Landline Number')
                            ->helperText('Optional. Leave blank if not applicable.'),
                    ]),

                    Fieldset::make('Address Information')->columns(3)->columnSpanFull()->schema([
                        TextInput::make('house_lot_bldg_purok')->label('House Lot/Purok')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                        TextInput::make('street_sitio_subdv')->label('Street/Sitio/Subdivision')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
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
                        TextInput::make('barangay')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                        TextInput::make('city_municipality')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                        TextInput::make('province')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                        TextInput::make('region')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                    ]),

                    Fieldset::make('Provincial Address (NCR residents only)')->columns(3)->columnSpanFull()->schema([
                        TextInput::make('provincial_house_lot_bldg_purok')->label('House Lot/Purok')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                        TextInput::make('provincial_street_sitio_subdv')->label('Street/Sitio/Subdivision')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                        TextInput::make('provincial_barangay')->label('Barangay')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                        TextInput::make('provincial_city_municipality')->label('City/Municipality')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                        TextInput::make('provincial_province')->label('Province')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
                        TextInput::make('provincial_region')->label('Region')->extraInputAttributes(['onInput' => 'this.value = this.value.toUpperCase()']),
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


                            ->default(MemberInformation::CS_SINGLE),
                        TextInput::make('religion'),
                        TextInput::make('name_of_spouse'),
                        TextInput::make('mother_maiden_name'),
                    ]),

                    Fieldset::make('Household Information')->columns(2)->columnSpanFull()->schema([
                        Checkbox::make('household_head')
                            ->label('Are you the household head?')
                            ->reactive()
                            ->columnSpanFull(),
                        TextInput::make('name_of_household_head')
                            ->label('Name of Household Head')
                            ->hidden(fn (Closure $get) => (bool) $get('household_head')),
                        TextInput::make('relationship_with_household_head')
                            ->label('Relationship with Household Head')
                            ->hidden(fn (Closure $get) => (bool) $get('household_head')),
                        TextInput::make('no_of_living_household_members')
                            ->label('No. of Living Household Members')
                            ->numeric(),
                        TextInput::make('no_of_male')
                            ->label('No. of Male')
                            ->numeric(),
                        TextInput::make('no_of_female')
                            ->label('No. of Female')
                            ->numeric(),
                    ]),

                    Fieldset::make('Person to Notify in Case of Emergency')->columns(2)->columnSpanFull()->schema([
                        TextInput::make('emergency_contact_name')
                            ->label('Full Name'),
                        TextInput::make('emergency_contact_number')
                            ->label('Contact Number'),
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

                        TextInput::make('indigenous_group_name')

                            ->label('Indigenous Group Name')->columnSpanFull()->hidden(fn(Closure $get) => !$get('is_indigenous_group_member')),
                    ]),

                    Fieldset::make('Identification')->columns(2)->columnSpanFull()->schema([
                        Checkbox::make('has_government_id')->label('With Government ID?')->reactive()->columnSpanFull(),
                        TextInput::make('id_type')->label('ID Type')

                            ->hidden(fn(Closure $get) => !$get('has_government_id')),
                        TextInput::make('id_number')->label('ID Number')


                            ->hidden(fn(Closure $get) => !$get('has_government_id')),
                        Checkbox::make('is_farmers_association_member')->label('Are you a Farmers Association Member?')->reactive()->columnSpanFull(),
                        TextInput::make('farmers_association_name')

                            ->label('Farmers Association Name')->columnSpanFull()->hidden(fn(Closure $get) => !$get('is_farmers_association_member')),
                        TextInput::make('farmers_association_name_2')
                            ->label('Farmers Association Name (2)')->columnSpanFull()->hidden(fn(Closure $get) => !$get('is_farmers_association_member')),
                        TextInput::make('farmers_association_name_3')
                            ->label('Farmers Association Name (3)')->columnSpanFull()->hidden(fn(Closure $get) => !$get('is_farmers_association_member')),
                    ]),
                ]),

            // Step 2: Livelihood Profile (Part 2 of the 01-2024 form)
            Step::make('Part II: Livelihood Profile')
                ->description('Select all applicable sources of livelihood.')
                ->schema([
                    Fieldset::make('Main Livelihood')->schema([
                        // Select::make('main_livelihood')
                        // ->reactive()
                        // ->multiple()
                        // // ->afterStateUpdated(function (Closure $set, $state) {
                        // //     dd($state);
                        // // })
                        CheckboxList::make('main_livelihood')

                            ->reactive()
                            ->helperText('Select all applicable sources of livelihood.')
                            ->label('MAIN LIVELIHOOD')
                            ->options(RsbsaRecord::LIVELIHOOD_OPTION)
                            ->columns(4)
                            ->label('Main Livelihood')
                            ->options(RsbsaRecord::LIVELIHOOD_OPTION)
                            ,

                    ]),

                    // Sub-details appear only for the livelihoods selected above.
                    Fieldset::make('Farmer — Type of Farming Activity')
                        ->columnSpanFull()
                        ->visible(fn (Closure $get) => in_array('Farmer', (array) $get('main_livelihood')))
                        ->schema([
                            CheckboxList::make('farmer_activities')
                                ->label('Farming activity')
                                ->options(RsbsaRecord::FARMER_ACTIVITIES)
                                ->columns(3),
                            TextInput::make('farmer_activities_other')
                                ->label('Other crops / livestock / poultry (specify)'),
                        ]),

                    Fieldset::make('Farmworker / Laborer — Kind of Work')
                        ->columnSpanFull()
                        ->visible(fn (Closure $get) => in_array('Farmworker/Laborer', (array) $get('main_livelihood')))
                        ->schema([
                            CheckboxList::make('farmworker_activities')
                                ->label('Kind of work')
                                ->options(RsbsaRecord::FARMWORKER_ACTIVITIES)
                                ->columns(3),
                            TextInput::make('farmworker_activities_other')
                                ->label('Others (specify)'),
                        ]),

                    Fieldset::make('Fisherfolk — Kind of Activity')
                        ->columnSpanFull()
                        ->visible(fn (Closure $get) => in_array('Fisherfolk', (array) $get('main_livelihood')))
                        ->schema([
                            CheckboxList::make('fisherfolk_activities')
                                ->label('Fishing activity')
                                ->options(RsbsaRecord::FISHERFOLK_ACTIVITIES)
                                ->columns(3),
                            TextInput::make('fisherfolk_activities_other')
                                ->label('Others (specify)'),
                        ]),

                    Fieldset::make('Agri-Youth — Type of Involvement')
                        ->columnSpanFull()
                        ->visible(fn (Closure $get) => in_array('Agri Youth', (array) $get('main_livelihood')))
                        ->schema([
                            CheckboxList::make('agri_youth_involvement')
                                ->label('Type of involvement')
                                ->options(RsbsaRecord::AGRI_YOUTH_INVOLVEMENT)
                                ->columns(2),
                            TextInput::make('agri_youth_involvement_other')
                                ->label('Others (specify)'),
                        ]),

                    Fieldset::make('Gross Annual Income (Last Year)')->columns(2)->columnSpanFull()->schema([
                        TextInput::make('gross_annual_income_farming')
                            ->label('Farming')
                            ->numeric()
                            ->prefix('₱'),
                        TextInput::make('gross_annual_income_nonfarming')
                            ->label('Non-Farming')
                            ->numeric()
                            ->prefix('₱'),
                    ]),

                ]),

            Step::make('Part III: Farm Parcels')
                ->description('Provide farm land / parcel information (Page 2).')
                ->schema([
                    Repeater::make('farm_parcels')
                        ->label('Farm Parcels')
                        ->createItemButtonLabel('Add Farm Parcel')
                        ->collapsible()
                        ->defaultItems(0)
                        ->columns(2)
                        ->schema([
                            TextInput::make('farm_location_barangay')->label('Farm Location - Barangay'),
                            TextInput::make('farm_location_city_municipality')->label('City/Municipality'),
                            TextInput::make('farm_location_province')->label('Province'),
                            TextInput::make('total_parcel_area')->label('Total Parcel Area (ha)')->numeric(),

                            Checkbox::make('within_ancestral_domain')->label('Within Ancestral Domain (AD)?'),
                            Checkbox::make('agrarian_reform_beneficiary')->label('Agrarian Reform Beneficiary (ARB)?'),
                            Checkbox::make('has_land_ownership_proof')->label('Submitted Proof of Land Ownership / Farming Agreement?')->columnSpanFull(),

                            Select::make('ownership_type')
                                ->label('Type of Ownership / Tenure')
                                ->options(\App\Models\RsbsaFarmParcel::OWNERSHIP_TYPES)
                                ->reactive(),
                            TextInput::make('ownership_other_specify')
                                ->label('Specify (if Others)')
                                ->hidden(fn (Closure $get) => $get('ownership_type') !== 'Others'),

                            TextInput::make('land_owner_name')->label('Name of Land Owner'),
                            TextInput::make('parcel_rsbsa_number')->label('Parcel RSBSA Number (system-generated)'),
                            TextInput::make('rotational_tiller_name')->label('Rotational Tiller - Full Name'),
                            TextInput::make('rotational_tiller_rsbsa_number')->label('Rotational Tiller - RSBSA Number'),
                            Textarea::make('remarks')->label('Remarks')->columnSpanFull(),

                            Repeater::make('commodities')
                                ->label('Commodities (use a new row for intercropping)')
                                ->createItemButtonLabel('Add Commodity')
                                ->defaultItems(0)
                                ->columnSpanFull()
                                ->columns(3)
                                ->schema([
                                    TextInput::make('cropping_schedule')->label('Cropping Schedule (e.g. Jan-Mar)'),
                                    TextInput::make('commodity')->label('Commodity'),
                                    TextInput::make('size')->label('Size (ha)')->numeric(),
                                    TextInput::make('no_of_heads')->label('No. of Heads / Trees')->numeric(),
                                    Select::make('farm_type')
                                        ->label('Farm Type')
                                        ->options(\App\Models\RsbsaFarmParcelCommodity::FARM_TYPES),
                                    Checkbox::make('organic_practitioner')->label('Organic Practitioner?'),
                                ]),
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
