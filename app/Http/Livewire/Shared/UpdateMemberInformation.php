<?php

namespace App\Http\Livewire\Shared;

use App\Models\City;
use App\Models\Gender;
use App\Models\Region;
use App\Models\Cluster;
use Livewire\Component;
use App\Models\Barangay;
use App\Models\Province;
use App\Models\Occupation;
use App\Models\MembershipStatus;
use App\Models\MemberInformation;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;

class UpdateMemberInformation extends Component implements HasForms
{
    use InteractsWithForms;

    public MemberInformation $member;
    public $data;

    protected function getFormSchema(): array
    {
        return [
            Grid::make(2)->schema([
                Fieldset::make('Profile Photo')
                    ->schema([
                        Placeholder::make('photo')
                            ->disableLabel()
                            ->content(new HtmlString('<img src="' . $this->member->profile_photo . '" class="rounded-full w-32 h-32">')),
                        FileUpload::make('profile_photo')->avatar()
                    ])
                    ->maxWidth('sm'),
                Fieldset::make('Personal Information')
                    ->schema([
                        TextInput::make('first_name')
                            ->label('First Name')
                            ->required(),
                        TextInput::make('surname')
                            ->label('Last Name')
                            ->required(),
                        TextInput::make('middle_name')
                            ->label('Middle Name'),
                        TextInput::make('suffix')
                            ->label('Suffix'),
                        DatePicker::make('date_of_birth')
                            ->required()
                            ->withoutTime(),
                        TextInput::make('place_of_birth')
                            ->required(),
                        Select::make('gender_id')
                            ->label('Gender')
                            ->disablePlaceholderSelection()
                            ->options(Gender::pluck('name', 'id'))
                            ->default(Gender::UNKNOWN),
                        Select::make('blood_type')->options([
                            'A' => 'A',
                            'B' => 'B',
                            'AB' => 'AB',
                            'O' => 'O',
                        ])
                            ->disablePlaceholderSelection(),
                        TextInput::make('religion'),
                    ]),
                Fieldset::make('Membership Status')
                    ->schema([
                        Select::make('status')->options([
                            MemberInformation::STATUS_ACTIVE => 'Active',
                            MemberInformation::STATUS_DECEASED => 'Deceased',
                            MemberInformation::STATUS_INACTIVE => 'Inactive',
                        ])->required(),
                        Select::make('cluster_id')
                            ->label('Cluster')
                            ->options(fn () => Cluster::orderByRaw('CAST(name AS UNSIGNED)')->pluck('name', 'id')),
                        TextInput::make('percentage')->required()->numeric()->minValue(0)->maxValue(100),
                        TextInput::make('darbc_id')->label('DARBC ID'),
                        Select::make('membership_status')
                            ->options(MembershipStatus::pluck('name', 'id'))
                            ->required()
                            ->disablePlaceholderSelection(),
                    ]),
                Fieldset::make('Address')
                    ->schema([
                        Select::make('address.region_code')
                            ->label('Region')
                            ->reactive()
                            ->options(Region::pluck('description', 'code')),
                        Select::make('address.province_code')
                            ->label('Province')
                            ->reactive()
                            ->options(fn ($get) => Province::where('region_code', $get('address.region_code'))->pluck('description', 'code')),
                        Select::make('address.city_code')
                            ->label('City/Municipality')
                            ->reactive()
                            ->options(fn ($get) => City::where('province_code', $get('address.province_code'))->pluck('description', 'code')),
                        Select::make('address.barangay_code')
                            ->label('Barangay')
                            ->reactive()
                            ->options(fn ($get) => Barangay::where('city_code', $get('address.city_code'))->pluck('description', 'code')),
                        TextInput::make('address.address_line')
                            ->label('Street name, Building, House No.')
                    ]),
                Fieldset::make('Occupation')
                    ->schema([
                        Radio::make('occupation')
                            ->options(Occupation::pluck('name', 'id'))
                            ->default(5)
                            ->required(),
                        TextInput::make('occupation_details')
                            ->label('If others, please specify')
                            ->required(fn ($get) => $get('occupation') == 4),
                    ]),
                Fieldset::make('Civil Status')
                    ->schema([
                        Select::make('civil_status')
                            ->options([
                                MemberInformation::CS_SINGLE => 'Single',
                                MemberInformation::CS_MARRIED => 'Married',
                                MemberInformation::CS_WIDOW => 'Widow',
                                MemberInformation::CS_LEGALLY_SEPARATED => 'Legally Separated',
                                MemberInformation::CS_UNKNOWN => 'Unknown',
                            ])
                            ->required()
                            ->default(MemberInformation::CS_SINGLE),
                        TextInput::make('spouse')->label('Name of Spouse'),
                        TextInput::make('mother_maiden_name')
                            ->label("Mother's Maiden Name"),
                        TableRepeater::make('children')
                            // ->disableItemMovement()
                            ->columnSpan(2)
                            ->hideLabels()
                            ->schema([
                                TextInput::make('name'),
                                DatePicker::make('date_of_birth')->withoutTime(),
                                TextInput::make('occupation'),
                                Select::make('educational_attainment')->options([
                                    'Elementary' => 'Elementary',
                                    'Secondary' => 'Secondary',
                                    'Vocational' => 'Vocational',
                                    'College' => 'College',
                                    'Graduate Studies' => 'Graduate Studies',
                                    'Others' => 'Others',
                                ])
                                    ->disablePlaceholderSelection(),
                                Select::make('blood_type')->options([
                                    'A' => 'A',
                                    'B' => 'B',
                                    'AB' => 'AB',
                                    'O' => 'O',
                                ])
                                    ->disablePlaceholderSelection(),
                            ]),
                    ]),
                Fieldset::make('IDs Required')
                    ->schema([
                        TextInput::make('sss_number')
                            ->validationAttribute('SSS Number')
                            ->label('SSS Number'),
                        TextInput::make('philhealth_number')
                            ->validationAttribute('PhilHealth Number')
                            ->label('PhilHealth Number'),
                        TextInput::make('tin_number')
                            ->validationAttribute('TIN Number')
                            ->label('TIN number'),
                        TextInput::make('contact_number')
                            ->label('Contact No.'),
                    ]),
                Fieldset::make('Other Fields')
                    ->schema([
                        TagsInput::make('spa')
                            ->label('SPA/Authorized Representative')
                            ->placeholder('New Entry'),
                        TagsInput::make('dependents')
                            ->label('Dependents')
                            ->placeholder('New Entry')
                    ]),
            ])
        ];
    }

    protected function getFormStatePath(): ?string
    {
        return 'data';
    }

    public function mount()
    {
        $this->form->fill([
            'first_name' => $this->member->user->first_name,
            'surname' => $this->member->user->surname,
            'middle_name' => $this->member->user->middle_name,
            'suffix' => $this->member->user->suffix,
            'darbc_id' => $this->member->darbc_id,
            'percentage' => $this->member->percentage,
            'date_of_birth' => $this->member->date_of_birth,
            'place_of_birth' => $this->member->place_of_birth,
            'gender_id' => $this->member->gender_id,
            'blood_type' => $this->member->blood_type,
            'religion' => $this->member->religion,
            'status' => $this->member->status,
            'cluster_id' => $this->member->cluster_id,
            'membership_status_id' => $this->member->membership_status_id,
            'occupation' => $this->member->occupation_id,
            'occupation_details' => $this->member->occupation_details,
            'civil_status' => $this->member->civil_status,
            'children' => $this->member->children,
            'spouse' => $this->member->spouse,
            'mother_maiden_name' => $this->member->mother_maiden_name,
            'sss_number' => $this->member->sss_number,
            'philhealth_number' => $this->member->philhealth_number,
            'tin_number' => $this->member->tin_number,
            'contact_number' => $this->member->contact_number,
            'spa' => $this->member->spa,
            'dependents' => $this->member->dependents,
        ]);
        $this->data['address']['region_code'] = $this->member->region_code;
        $this->data['address']['province_code'] = $this->member->province_code;
        $this->data['address']['city_code'] = $this->member->city_code;
        $this->data['address']['barangay_code'] = $this->member->barangay_code;
        $this->data['address']['address_line'] = $this->member->address_line;
    }

    public function render()
    {
        return view('livewire.shared.update-member-information');
    }

    public function save()
    {
        DB::beginTransaction();
        $this->member->user()->update([
            'first_name' => $this->data['first_name'],
            'surname' => $this->data['surname'],
            'middle_name' => $this->data['middle_name'],
            'suffix' => $this->data['suffix'],
        ]);
        $this->member->update([
            'darbc_id' => $this->data['darbc_id'],
            'percentage' => $this->data['percentage'],
            'date_of_birth' => $this->data['date_of_birth'],
            'place_of_birth' => $this->data['place_of_birth'],
            'gender_id' => $this->data['gender_id'],
            'blood_type' => $this->data['blood_type'],
            'religion' => $this->data['religion'],
            'status' => $this->data['status'],
            'cluster_id' => $this->data['cluster_id'],
            'membership_status_id' => $this->data['membership_status_id'],
            'region_code' => $this->data['address']['region_code'],
            'province_code' => $this->data['address']['province_code'],
            'city_code' => $this->data['address']['city_code'],
            'barangay_code' => $this->data['address']['barangay_code'],
            'address_line' => $this->data['address']['address_line'],
            'occupation_id' => $this->data['occupation'],
            'occupation_details' => $this->data['occupation_details'],
            'civil_status' => $this->data['civil_status'],
            'spouse' => $this->data['spouse'],
            'mother_maiden_name' => $this->data['mother_maiden_name'],
            'children' => $this->data['children'],
            'sss_number' => $this->data['sss_number'],
            'philhealth_number' => $this->data['philhealth_number'],
            'tin_number' => $this->data['tin_number'],
            'contact_number' => $this->data['contact_number'],
            'spa' => $this->data['spa'],
            'dependents' => $this->data['dependents'],
        ]);
        if ($this->data['profile_photo']) {
            $this->member->addMedia(collect($this->data['profile_photo'])?->first())->toMediaCollection('profile_photo');
        }
        DB::commit();
        Notification::make()->title('Changes saved!')->success()->send();
    }
}