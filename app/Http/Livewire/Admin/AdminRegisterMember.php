<?php

namespace App\Http\Livewire\Admin;

use App\Models\City;
use App\Models\User;
use App\Models\Gender;
use App\Models\Region;
use App\Models\Cluster;
use Livewire\Component;
use App\Models\Barangay;
use App\Models\Province;
use App\Models\Occupation;
use App\Models\MembershipStatus;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Intervention\Image\Facades\Image;
use App\Forms\Components\SlimRepeater;
use App\Forms\Components\VerticalWizard;
use App\Models\MemberInformation;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;

class AdminRegisterMember extends Component implements HasForms
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
                            DatePicker::make('data.date_of_birth')->withoutTime()->required(),
                            TextInput::make('data.place_of_birth')->required(),
                            Select::make('data.gender_id')->label('Gender')->options(Gender::pluck('name', 'id'))->required(),
                            Select::make('data.blood_type')->options([
                                'A' => 'A',
                                'B' => 'B',
                                'AB' => 'AB',
                                'O' => 'O',
                            ])->required(),
                            TextInput::make('data.religion')->required(),
                        ]),

                    ]),
                Step::make('Membership Status')
                    ->description('Select membership status.')
                    ->schema([
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
                                    ->options(User::has('member_information')->get()->pluck('full_name', 'id'))
                                    ->searchable()
                                    ->required(),
                                Placeholder::make('data.membership_status_requirements')->view('forms.components.members.membership-status-requirements'),
                                FileUpload::make('consent_form')->required(),
                                FileUpload::make('id_documents')
                                    ->label('Identification')
                                    ->multiple()
                                    ->required(),
                            ])
                            ->visible(fn ($get) => $get('data.membership_status') == 2),

                    ]),
                Step::make('Address')
                    ->description('Add complete address.')
                    ->schema([
                        Select::make('data.address.region_code')
                            ->label('Region')
                            ->reactive()
                            ->options(Region::pluck('description', 'code'))
                            ->required(),
                        Select::make('data.address.province_code')
                            ->label('Province')
                            ->reactive()
                            ->options(fn ($get) => Province::where('region_code', $get('data.address.region_code'))->pluck('description', 'code'))
                            ->required(),
                        Select::make('data.address.city_code')
                            ->label('City/Municipality')
                            ->reactive()
                            ->options(fn ($get) => City::where('province_code', $get('data.address.province_code'))->pluck('description', 'code'))
                            ->required(),
                        Select::make('data.address.barangay_code')
                            ->label('Barangay')
                            ->reactive()
                            ->options(fn ($get) => Barangay::where('city_code', $get('data.address.city_code'))->pluck('description', 'code'))
                            ->required(),
                        TextInput::make('data.address.address_line')
                            ->label('Street name, Building, House No.')
                            ->required()
                    ]),
                Step::make('Occupation')
                    ->description('Identify your occupation.')
                    ->schema([
                        Radio::make('data.occupation')
                            ->options(Occupation::pluck('name', 'id'))
                            ->default(Occupation::first()->id)
                            ->required(),
                        TextInput::make('data.occupation_details')
                            ->label('If others, please specify')
                            ->required(fn ($get) => $get('data.occupation') == 4),
                    ]),
                Step::make('Civil Status')
                    ->description("Check your civil status, spouse's name if married, and children's name if you have any.")
                    ->schema([
                        Select::make('data.civil_status')
                            ->options([
                                1 => 'Single',
                                2 => 'Married',
                                3 => 'Widowed',
                            ])
                            ->required()
                            ->default(1),
                        SlimRepeater::make('data.children')
                            ->columns(4)
                            ->schema([
                                TextInput::make('name')->required()->disableLabel(),
                                DatePicker::make('date_of_birth')->required()->disableLabel()->withoutTime(),
                                TextInput::make('educational_attainment')->required()->disableLabel(),
                                TextInput::make('blood_type')->required()->disableLabel(),
                            ])
                            ->disableItemMovement()
                            ->default([])
                            ->createItemButtonLabel('Add Child'),
                    ]),
                Step::make('IDs Required')
                    ->description('DARBC, SSS, PhilHealth, TIN, Contact No., and Cluster number.')
                    ->schema([
                        TextInput::make('data.darbc_id')
                            ->label('DARBC ID number')
                            ->required(),
                        TextInput::make('data.sss_number')
                            ->label('SSS Number')
                            ->required(),
                        TextInput::make('data.philhealth_number')
                            ->label('PhilHealth Number')
                            ->required(),
                        TextInput::make('data.tin_number')
                            ->label('TIN number')
                            ->required(),
                        TextInput::make('data.contact_number')
                            ->label('Contact No.')
                            ->required(),
                        Select::make('data.cluster_id')
                            ->label('Cluster')
                            ->options(Cluster::pluck('name', 'id'))
                            ->required()

                    ]),
                Step::make('Date and Signature')
                    ->description('Date of membership application and signature is required.')
                    ->schema([
                        DatePicker::make('data.application_date')
                            ->withoutTime()
                            ->default(today())
                            ->label('Date')
                            ->required(),
                        ViewField::make('data.signature')
                            ->view('forms.components.members.signature')
                            ->label('Signature')
                            ->required(),
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
        if ($isReplacement) {
            $toReplace = MemberInformation::firstWhere('user_id', $this->data['replacement_member']);
            if (!$toReplace) {
                DB::rollBack();
                Notification::make()->title('Member for replacement not found.')->danger()->send();
                return;
            } else {
                $toReplace->update([
                    'status' => 3,
                ]);
                $successor_number = $toReplace->successor_number + 1;
                $original_member_id = $toReplace->user_id;
            }
        }
        $member_information = MemberInformation::create([
            'status' => $this->data['status'],
            'darbc_id' => $this->data['darbc_id'],
            'user_id' => $user->id,
            'cluster_id' => $this->data['cluster_id'],
            'successor_number' => $successor_number,
            'original_member_id' => $original_member_id,
            'date_of_birth' => $this->data['date_of_birth'],
            'place_of_birth' => $this->data['place_of_birth'],
            'gender_id' => $this->data['gender_id'],
            'blood_type' => $this->data['blood_type'],
            'religion' => $this->data['religion'],
            'membership_status_id' => $this->data['membership_status'],
            'occupation_id' => $this->data['occupation'],
            'occupation_details' => $this->data['occupation_details'],
            'region_code' => $this->data['address']['region_code'],
            'province_code' => $this->data['address']['province_code'],
            'city_code' => $this->data['address']['city_code'],
            'barangay_code' => $this->data['address']['barangay_code'],
            'address_line' => $this->data['address']['address_line'],
            'civil_status' => $this->data['civil_status'],
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
        if ($this->consent_form) {
            $member_information->addMedia(collect($this->consent_form)?->first())->toMediaCollection('consent_form');
        }
        foreach ($this->id_documents as $document) {
            $member_information->addMedia($document)->toMediaCollection('identification_documents');
        }
        $path = storage_path('app/signatures/' . now()->timestamp . '-signature.png');
        Image::make($this->data['signature'])->save($path);
        $user->addMedia($path)->toMediaCollection('signature');
        DB::commit();

        Notification::make()->title('Member successfully registered.')->success()->send();
        $this->redirect(route('administrator.manage-members'));
    }

    public function mount()
    {
        $this->form->fill();

        // $this->data['first_name'] = 'John';
        // $this->data['surname'] = 'Casero';
        // $this->data['date_of_birth'] = now()->subYears(20);
        // $this->data['place_of_birth'] = 'Somewhere';
        // $this->data['gender_id'] = 1;
        // $this->data['blood_type'] = 'A';
        // $this->data['religion'] = 'Roman Catholic';
        // $this->data['address']['region_code'] = '01';
        // $this->data['address']['province_code'] = '0128';
        // $this->data['address']['city_code'] = '012801';
        // $this->data['address']['barangay_code'] = '012801001';
        // $this->data['address']['address_line'] = 'Block 14, Lot 9';
        // $this->data['darbc_id'] = '1234';
        // $this->data['sss_number'] = '1234';
        // $this->data['philhealth_number'] = '1234';
        // $this->data['tin_number'] = '1234';
        // $this->data['contact_number'] = '1234';
        // $this->data['cluster_id'] = 1;
        // $this->data['children'] = [
        //     [
        //         'name' => 'John Doe',
        //         'date_of_birth' => now()->subYears(5),
        //         'educational_attainment' => 'College',
        //         'blood_type' => 'A',
        //     ],
        //     [
        //         'name' => 'Jane Doe',
        //         'date_of_birth' => now()->subYears(3),
        //         'educational_attainment' => 'College',
        //         'blood_type' => 'B',
        //     ],
        //     [
        //         'name' => 'Jay Doe',
        //         'date_of_birth' => now()->subYears(3),
        //         'educational_attainment' => 'College',
        //         'blood_type' => 'O',
        //     ],
        // ];
    }


    public function render()
    {
        return view('livewire.admin.admin-register-member');
    }
}
