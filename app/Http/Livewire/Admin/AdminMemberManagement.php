<?php

namespace App\Http\Livewire\Admin;

use App\Models\Gender;
use Livewire\Component;
use App\Models\MemberInformation;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Support\Facades\DB;

class AdminMemberManagement extends Component implements HasTable
{
    use InteractsWithTable;


    protected function getTableQuery()
    {
        return MemberInformation::orderBy('darbc_id');
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('darbc_id')
                ->label('DARBC ID')
                ->extraAttributes(['class' => 'font-semibold text-sm'])
                ->searchable(),
            TextColumn::make('user.full_name')
                ->label('Name')
                ->searchable(['first_name', 'surname'])
                ->extraAttributes(['class' => 'font-semibold text-sm'])
                ->sortable(['surname']),
            BadgeColumn::make('succession_number')
                ->colors([
                    'success'
                ])
                ->formatStateUsing(fn ($state) => $state == '0' ? 'Original Owner' : ordinal($state) . ' Successor')
                ->label('Ownership'),
            BadgeColumn::make('membership_status.name')
                ->colors([
                    'success'
                ])
                ->label('Status'),
            TextColumn::make('occupation.name')
                ->extraAttributes(['class' => 'font-semibold text-sm']),
            TextColumn::make('created_at')
                ->extraAttributes(['class' => 'font-semibold text-sm'])
                ->label('Member since')
                ->date(),

        ];
    }

    protected function getTableActions()
    {
        return [
            EditAction::make('edit')
                ->mountUsing(fn ($form, MemberInformation $record) => $form->fill([
                    'first_name' => $record->user->first_name,
                    'surname' => $record->user->surname,
                    'middle_name' => $record->user->middle_name,
                    'suffix' => $record->user->suffix,
                    'date_of_birth' => $record->date_of_birth,
                    'place_of_birth' => $record->place_of_birth,
                    'gender_id' => $record->gender_id,
                    'blood_type' => $record->blood_type,
                    'religion' => $record->religion,
                    'status' => $record->status,
                ]))
                ->action(function ($record, $data) {
                    DB::beginTransaction();
                    $record->user()->update([
                        'first_name' => $data['first_name'],
                        'surname' => $data['surname'],
                        'middle_name' => $data['middle_name'],
                        'suffix' => $data['suffix'],
                    ]);
                    $record->update([
                        'date_of_birth' => $data['date_of_birth'],
                        'place_of_birth' => $data['place_of_birth'],
                        'gender_id' => $data['gender_id'],
                        'blood_type' => $data['blood_type'],
                        'religion' => $data['religion'],
                        'status' => $data['status'],
                    ]);
                    DB::commit();
                    Notification::make()->title('Changes saved!')->success()->send();
                })
                ->form([
                    Grid::make(2)->schema([
                        TextInput::make('first_name')
                            ->label('First Name'),
                        TextInput::make('surname')
                            ->label('Last Name'),
                        TextInput::make('middle_name')
                            ->label('Middle Name'),
                        TextInput::make('suffix')
                            ->label('Suffix'),
                        DatePicker::make('date_of_birth')
                            ->withoutTime()->required(),
                        TextInput::make('place_of_birth')->required(),
                        Select::make('gender_id')
                            ->label('Gender')
                            ->options(Gender::pluck('name', 'id'))->required(),
                        Select::make('blood_type')->options([
                            'A' => 'A',
                            'B' => 'B',
                            'AB' => 'AB',
                            'O' => 'O',
                        ])->required(),
                        TextInput::make('religion')->required(),
                        Select::make('status')->options([
                            MemberInformation::STATUS_ACTIVE => 'Active',
                            MemberInformation::STATUS_DECEASED => 'Deceased',
                            MemberInformation::STATUS_INACTIVE => 'Inactive',
                        ])->required(),
                    ])
                ])
                ->color('success')
                ->button(),
            Action::make('restrictions')
                ->label('Restrictions')
                ->button()
                ->outlined()
                ->icon('heroicon-o-lock-closed')
                ->url(fn ($record) => route('administrator.manage-member-restrictions', ['member' => $record])),
            DeleteAction::make('delete')
                ->action(function ($record) {
                    if ($record->user->clusters_lead()->exists()) {
                        Notification::make()
                            ->title('Member is currently a cluster leader.')
                            ->body("Please replace their cluster's leader before deleting this member.")
                            ->warning()
                            ->send();
                        return;
                    } else {
                        DB::beginTransaction();
                        $record->delete();
                        $record->user()->delete();
                        DB::commit();
                        Notification::make()->title('Member deleted!')->success()->send();
                    }
                }),
        ];
    }

    public function render()
    {
        return view('livewire.admin.admin-member-management');
    }
}
