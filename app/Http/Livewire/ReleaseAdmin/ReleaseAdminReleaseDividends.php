<?php

namespace App\Http\Livewire\ReleaseAdmin;

use DB;
use App\Models\User;
use App\Models\Gender;
use App\Models\Occupation;
use Illuminate\Support\Str;
use App\Models\MembershipStatus;
use App\Models\MemberInformation;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use App\Http\Livewire\Shared\ReleaseDividends;

class ReleaseAdminReleaseDividends extends ReleaseDividends
{
    protected function getTableActions()
    {
        return [
            Action::make('transfer')
                ->button()
                ->label('Transfer')
                ->color('primary')
                ->action(function ($data, $record) {
                    if ($data['member_type'] == 0) {
                        $record->update([
                            'user_id' => $data['user_id']
                        ]);
                    } else {
                        DB::beginTransaction();
                        $original_user = $record->user;
                        $user = User::create([
                            'first_name' => $data['first_name'],
                            'middle_name' => $data['middle_name'],
                            'surname' => $data['surname'],
                            'suffix' => $data['suffix'],
                            "username" => str($data["first_name"] . ' ' . $data["surname"] . ' ' . Str::random(5))->slug('-'),
                            "password" => bcrypt(now()->timestamp),
                        ]);
                        MemberInformation::create([
                            'user_id' => $user->id,
                            'darbc_id' =>  $original_user->member_information->darbc_id,
                            'original_member_id' => $original_user->id,
                            'reference_number' =>  $original_user->member_information->darbc_id,
                            'lineage_identifier' => $original_user->member_information->lineage_identifier,
                            'succession_number' => $original_user->member_information->succession_number + 1,
                            'gender_id' => Gender::UNKNOWN,
                            'membership_status_id' => MembershipStatus::REPLACEMENT,
                            'occupation_id' => Occupation::UNKNOWN,
                            'application_date' => today(),
                        ]);
                        $original_user->update([
                            'status' => MemberInformation::STATUS_INACTIVE,
                        ]);
                        $record->update([
                            'user_id' => $user->id
                        ]);
                        DB::commit();
                    }

                    Notification::make()->title('Dividend transferred')->success()->send();
                })
                ->form(fn ($record) => [
                    Radio::make('member_type')
                        ->label('New/Existing Member')
                        ->options([
                            0 => 'Existing',
                            1 => 'New',
                        ])
                        ->reactive()
                        ->default(0),
                    Select::make('user_id')
                        ->label('User')
                        ->options(User::has('member_information')->whereNot('users.id', $record->user_id)->whereRelation('member_information', 'lineage_identifier', $record->user->member_information->lineage_identifier)->pluck('full_name', 'id'))
                        ->searchable()
                        ->required()
                        ->visible(fn ($get) => $get('member_type') == 0)
                        ->preload(),
                    Fieldset::make('Member Information')
                        ->schema([
                            TextInput::make('first_name')
                                ->required()
                                ->maxLength(191),
                            TextInput::make('middle_name')
                                ->maxLength(191),
                            TextInput::make('surname')
                                ->required()
                                ->maxLength(191),
                            TextInput::make('suffix')
                                ->maxLength(191),
                        ])->visible(fn ($get) => $get('member_type') == 1)
                ]),
        ];
    }

    public function render()
    {
        return view('livewire.release-admin.release-admin-release-dividends');
    }
}
