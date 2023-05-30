<?php

namespace App\Http\Livewire\Shared;

use App\Models\City;
use App\Models\User;
use App\Models\Gender;
use App\Models\Region;
use App\Models\Cluster;
use Livewire\Component;
use App\Models\Barangay;
use App\Models\Province;
use App\Models\Occupation;
use Illuminate\Support\Str;
use App\Models\MembershipStatus;
use App\Models\MemberInformation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Intervention\Image\Facades\Image;
use Filament\Forms\Components\Section;
use App\Forms\Components\VerticalWizard;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

class RegisterMember extends Component implements HasForms
{
    use InteractsWithForms;

    public $profile_photo;
    public $consent_form;
    public $id_documents;
    public $data;

    protected function getFormSchema()
    {
        return [
            VerticalWizard::make([
                Step::make('Personal Information')
                    ->description('Provide your personal information.')
                    ->schema([
                        FileUpload::make('profile_photo')->avatar(),
                        Grid::make(2)->schema([
                            TextInput::make('data.first_name')->required(),
                            TextInput::make('data.surname')->required(),
                            TextInput::make('data.middle_name'),
                            TextInput::make('data.suffix'),
                            DatePicker::make('data.date_of_birth')->required()->withoutTime(),
                            TextInput::make('data.place_of_birth')->required(),
                            Select::make('data.gender_id')
                                ->default(Gender::UNKNOWN)
                                ->label('Gender')
                                ->required()
                                ->disablePlaceholderSelection()
                                ->options(Gender::pluck('name', 'id')),
                            Select::make('data.blood_type')->options([
                                'A' => 'A',
                                'B' => 'B',
                                'AB' => 'AB',
                                'O' => 'O',
                                'Unknown' => 'Unknown',
                            ]),
                            TextInput::make('data.religion'),
                        ]),

                    ]),
                Step::make('Membership Status')
                    ->description('Select membership status.')
                    ->schema([
                        TextInput::make('data.percentage')
                            ->default(100.00)
                            ->required()
                            ->numeric()
                            ->minValue(0)->maxValue(100),
                        Select::make('data.status')->options([
                            MemberInformation::STATUS_ACTIVE => 'Active',
                            MemberInformation::STATUS_DECEASED => 'Deceased',
                            MemberInformation::STATUS_INACTIVE => 'Inactive',
                        ])
                            ->default(MemberInformation::STATUS_ACTIVE)
                            ->required(),
                        Select::make('data.membership_status')
                            ->options(MembershipStatus::pluck('name', 'id'))
                            ->default(MembershipStatus::ORIGINAL)
                            ->reactive()
                            ->required(),
                        Section::make('Replacement Details')
                            ->description('Provide details of the member being replaced.')
                            ->schema([
                                Select::make('data.replacement_member')
                                    ->options(User::has('member_information')->pluck('full_name', 'id'))
                                    ->searchable()
                                    ->reactive()
                                    ->afterStateUpdated(fn ($set, $state) => $set('data.darbc_id', MemberInformation::firstWhere('user_id', $state)->darbc_id))
                                    ->required(),
                                Select::make('data.old_member_status')->options([
                                    MemberInformation::STATUS_ACTIVE => 'Active',
                                    MemberInformation::STATUS_DECEASED => 'Deceased',
                                    MemberInformation::STATUS_INACTIVE => 'Inactive',
                                ])
                                    ->default(MemberInformation::STATUS_DECEASED)
                                    ->required(),
                                Placeholder::make('data.membership_status_requirements')->view('forms.components.members.membership-status-requirements'),
                                FileUpload::make('documents')
                                    ->label('Required Documents')
                                    ->multiple(),
                            ])
                            ->visible(fn ($get) => $get('data.membership_status') == MembershipStatus::REPLACEMENT),

                    ]),
                Step::make('Address')
                    ->description('Add complete address.')
                    ->schema([
                        Select::make('data.address.region_code')
                            ->label('Region')
                            ->reactive()
                            ->options(Region::pluck('description', 'code')),
                        Select::make('data.address.province_code')
                            ->label('Province')
                            ->reactive()
                            ->options(fn ($get) => Province::where('region_code', $get('data.address.region_code'))->pluck('description', 'code')),
                        Select::make('data.address.city_code')
                            ->label('City/Municipality')
                            ->reactive()
                            ->options(fn ($get) => City::where('province_code', $get('data.address.province_code'))->pluck('description', 'code')),
                        Select::make('data.address.barangay_code')
                            ->label('Barangay')
                            ->reactive()
                            ->options(fn ($get) => Barangay::where('city_code', $get('data.address.city_code'))->pluck('description', 'code')),
                        TextInput::make('data.address.address_line')
                            ->label('Street name, Building, House No.')

                    ]),
                Step::make('Occupation')
                    ->description('Identify your occupation.')
                    ->schema([
                        Radio::make('data.occupation')
                            ->options(Occupation::pluck('name', 'id'))
                            ->default(5)
                            ->required(),
                        TextInput::make('data.occupation_details')
                            ->label('If others, please specify'),
                    ]),
                Step::make('Civil Status')
                    ->description("Check your civil status, spouse's name if married, and children's name if you have any.")
                    ->schema([
                        Select::make('data.civil_status')
                            ->options([
                                MemberInformation::CS_SINGLE => 'Single',
                                MemberInformation::CS_MARRIED => 'Married',
                                MemberInformation::CS_WIDOW => 'Widow',
                                MemberInformation::CS_LEGALLY_SEPARATED => 'Legally Separated',
                                MemberInformation::CS_UNKNOWN => 'Unknown',
                            ])
                            ->required()
                            ->default(MemberInformation::CS_SINGLE),
                        TextInput::make('data.spouse')
                            ->label('Name of Spouse'),
                        TextInput::make('data.mother_maiden_name')->label("Mother's Maiden Name"),
                        TableRepeater::make('data.children')
                            ->disableItemMovement()
                            ->hideLabels()
                            ->columnWidths([
                                'name' => '300px',
                                'occupation' => '180px',
                            ])
                            ->schema([
                                TextInput::make('name'),
                                DatePicker::make('date_of_birth')->withoutTime(),
                                Select::make('educational_attainment')->options([
                                    'Elementary' => 'Elementary',
                                    'Elementary undergraduate' => 'Elementary undergraduate',
                                    'Elementary graduate' => 'Elementary graduate',
                                    'Secondary' => 'Secondary',
                                    'Secondary undergraduate' => 'Secondary undergraduate',
                                    'Secondary graduate' => 'Secondary graduate',
                                    'Vocational' => 'Vocational',
                                    'College' => 'College',
                                    'Tertiary undergraduate' => 'Tertiary undergraduate',
                                    'Tertiary graduate' => 'Tertiary graduate',
                                    'Graduate Studies' => 'Graduate Studies',
                                    'Others' => 'Others',
                                ])
                                    ->disablePlaceholderSelection(),
                                Select::make('blood_type')->options([
                                    'A' => 'A',
                                    'B' => 'B',
                                    'AB' => 'AB',
                                    'O' => 'O',
                                    'Unknown' => 'Unknown',
                                ])
                                    ->disablePlaceholderSelection(),
                                TextInput::make('occupation'),
                            ]),
                    ]),
                Step::make('IDs Required')
                    ->description('DARBC, SSS, PhilHealth, TIN, Contact No., and Cluster number.')
                    ->schema([
                        TextInput::make('data.darbc_id')
                            ->label('DARBC ID number')
                            ->validationAttribute('DARBC ID')
                            ->disabled(fn ($get) => $get('data.membership_status') == MembershipStatus::REPLACEMENT)
                            ->required(),
                        TextInput::make('data.sss_number')
                            ->validationAttribute('SSS Number')
                            ->label('SSS Number'),
                        TextInput::make('data.philhealth_number')
                            ->validationAttribute('PhilHealth Number')
                            ->label('PhilHealth Number'),
                        TextInput::make('data.tin_number')
                            ->validationAttribute('TIN Number')
                            ->label('TIN number'),
                        TextInput::make('data.contact_number')
                            ->label('Contact No.'),
                        Select::make('data.cluster_id')
                            ->label('Cluster')
                            ->options(Cluster::pluck('name', 'id')),
                    ]),
                Step::make('Application Date and Signature')
                    ->description('Date of membership application and signature is required.')
                    ->schema([
                        DatePicker::make('data.application_date')
                            ->withoutTime()
                            ->default(today())
                            ->label('Date')
                            ->required(),
                        ViewField::make('data.signature')
                            ->view('forms.components.members.signature')
                            ->label('Signature'),
                    ]),
                Step::make('Summary')
                    ->description('Review and submit.')
                    ->schema([
                        Placeholder::make('data.summary')->view('forms.components.members.summary', [
                            'summary' => $this->data,
                        ]),
                    ]),

            ])
                ->submitAction(new HtmlString('<button class="p-1 px-2 text-sm font-semibold text-white rounded bg-primary-500" wire:click="register">Finish <span wire:loading class="animate-bounce">...</span></button>'))
        ];
    }

    public function register()
    {
        DB::beginTransaction();
        $user = User::create([
            'first_name' => $this->data['first_name'],
            'middle_name' => $this->data['middle_name'],
            'surname' => $this->data['surname'],
            'suffix' => $this->data['suffix'],
            'username' => str($this->data['first_name'])->slug('')->append('-' . now()->timestamp)->toString(),
            'password' => Hash::make(now()->timestamp),
        ]);
        $isReplacement = $this->data['membership_status'] == 2;
        $successor_number = 0;
        $original_member_id = null;
        $lineage_identifier = Str::random(10);
        if ($isReplacement) {
            $toReplace = MemberInformation::firstWhere('user_id', $this->data['replacement_member']);
            if (!$toReplace) {
                DB::rollBack();
                Notification::make()->title('Member for replacement not found.')->danger()->send();
                return;
            } else {
                $toReplace->update([
                    'status' => $this->data['old_member_status'],
                ]);
                $lineage_identifier = $toReplace->lineage_identifier;
                $successor_number = $toReplace->succession_number + 1;
                $original_member_id = $toReplace->user_id;
            }
        }
        $member_information = MemberInformation::create([
            'percentage' => $this->data['percentage'],
            'status' => $this->data['status'],
            'darbc_id' => $this->data['darbc_id'],
            'user_id' => $user->id,
            'cluster_id' => $this->data['cluster_id'],
            'succession_number' => $successor_number,
            'lineage_identifier' => $lineage_identifier,
            'original_member_id' => $original_member_id,
            'date_of_birth' => $this->data['date_of_birth'],
            'place_of_birth' => $this->data['place_of_birth'],
            'gender_id' => $this->data['gender_id'],
            'blood_type' => $this->data['blood_type'],
            'religion' => $this->data['religion'],
            'is_darbc_member' => $this->data['membership_status'] == MembershipStatus::ORIGINAL,
            'membership_status_id' => $this->data['membership_status'],
            'occupation_id' => $this->data['occupation'],
            'occupation_details' => $this->data['occupation_details'],
            'region_code' => $this->data['address']['region_code'],
            'province_code' => $this->data['address']['province_code'],
            'city_code' => $this->data['address']['city_code'],
            'barangay_code' => $this->data['address']['barangay_code'],
            'address_line' => $this->data['address']['address_line'],
            'civil_status' => $this->data['civil_status'],
            'spouse' => $this->data['spouse'],
            'mother_maiden_name' => $this->data['mother_maiden_name'],
            'children' => collect($this->data['children'])->values(),
            'sss_number' => $this->data['sss_number'],
            'philhealth_number' => $this->data['philhealth_number'],
            'tin_number' => $this->data['tin_number'],
            'contact_number' => $this->data['contact_number'],
            'application_date' => $this->data['application_date'],
        ]);

        if ($this->profile_photo) {
            $member_information->addMedia(collect($this->profile_photo)?->first())->toMediaCollection('profile_photo');
        }

        foreach ($this->documents as $document) {
            $member_information->addMedia($document)->toMediaCollection('documents');
        }

        if ($this->data['signature']) {
            $path = storage_path('app/signatures/' . now()->timestamp . '-signature.png');
            Image::make($this->data['signature'])->save($path);
            $user->addMedia($path)->toMediaCollection('signature');
        }
        DB::commit();
        Notification::make()->title('Member successfully registered.')->success()->send();
        $this->redirect($this->getRedirectionRoute());
    }

    public function mount()
    {
        $this->form->fill();

        if (app()->environment('local')) {
            $this->data['first_name'] = 'John';
            $this->data['surname'] = 'Casero';
            $this->data['date_of_birth'] = now()->subYears(20);
            $this->data['place_of_birth'] = 'Somewhere';
            $this->data['blood_type'] = 'A';
            $this->data['religion'] = 'Roman Catholic';
            $this->data['address']['region_code'] = '01';
            $this->data['address']['province_code'] = '0128';
            $this->data['address']['city_code'] = '012801';
            $this->data['address']['barangay_code'] = '012801001';
            $this->data['address']['address_line'] = 'Block 14, Lot 9';
            $this->data['darbc_id'] = '1234';
            $this->data['sss_number'] = '1234';
            $this->data['philhealth_number'] = '1234';
            $this->data['tin_number'] = '1234';
            $this->data['contact_number'] = '1234';
            $this->data['children'] = [
                [
                    'name' => 'John Doe',
                    'date_of_birth' => now()->subYears(5),
                    'educational_attainment' => 'College',
                    'blood_type' => 'A',
                ],
                [
                    'name' => 'Jane Doe',
                    'date_of_birth' => now()->subYears(3),
                    'educational_attainment' => 'College',
                    'blood_type' => 'B',
                ],
                [
                    'name' => 'Jay Doe',
                    'date_of_birth' => now()->subYears(3),
                    'educational_attainment' => 'College',
                    'blood_type' => 'O',
                ],
            ];
        }
    }

    protected function getRedirectionRoute()
    {
        return '#';
    }

    public function render()
    {
        return view('livewire.shared.register-member');
    }
}
