<?php

namespace App\Http\Livewire\Shared;

use App\Models\Gender;
use Livewire\Component;
use App\Models\MemberInformation;
use App\Models\MembershipStatus;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;

class MemberManagement extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery()
    {
        return MemberInformation::query();
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'asc';
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'darbc_id';
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('darbc_id')
                ->label('DARBC ID')
                ->sortable()
                ->searchable(),
            TextColumn::make('percentage')
                ->sortable(),
            TextColumn::make('user.surname')
                ->label('Last Name')
                ->searchable(isIndividual: true),
            TextColumn::make('user.first_name')
                ->label('First Name')
                ->searchable(isIndividual: true),
            BadgeColumn::make('succession_number')
                ->colors([
                    'success'
                ])
                ->sortable()
                ->formatStateUsing(fn ($state) => $state == '0' ? 'Original' : ordinal($state) . ' Successor')
                ->label('Ownership'),
            BadgeColumn::make('status')
                ->enum([
                    MemberInformation::STATUS_ACTIVE => 'Active',
                    MemberInformation::STATUS_DECEASED => 'Deceased',
                    MemberInformation::STATUS_INACTIVE => 'Inactive',
                ])
                ->colors([
                    'primary',
                    'success' => MemberInformation::STATUS_ACTIVE,
                    'danger' => MemberInformation::STATUS_DECEASED,
                    'warning' => MemberInformation::STATUS_INACTIVE,
                ])
                ->label('Status'),
            TextColumn::make('application_date')
                ->label('Member since')
                ->date(),
            BadgeColumn::make('missing_details_count')
                ->label('Missing Details')
                ->color('warning'),

        ];
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('status')
                ->label('Status')
                ->placeholder('All')
                ->options([
                    MemberInformation::STATUS_ACTIVE => 'Active',
                    MemberInformation::STATUS_DECEASED => 'Deceased',
                    MemberInformation::STATUS_INACTIVE => 'Inactive',
                ]),
            SelectFilter::make('membership_status_id')
                ->label('Membership')
                ->placeholder('All')
                ->options(MembershipStatus::pluck('name', 'id')),
        ];
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    protected function getTableActions()
    {
        return [
            Action::make('history')
                ->label('History')
                ->button()
                ->icon('heroicon-o-clock')
                ->url(fn ($record) => $this->getHistoryRoute($record)),
            Action::make('restrictions')
                ->label('Restrictions')
                ->button()
                ->outlined()
                ->icon('heroicon-o-lock-closed')
                ->url(fn ($record) => $this->getMemberRestrictionsRoute($record)),
            ActionGroup::make([
                EditAction::make('edit')
                    ->mountUsing(fn ($form, MemberInformation $record) => $form->fill([
                        'percentage' => $record->percentage,
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
                            'percentage' => $data['percentage'],
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
                                ->withoutTime(),
                            TextInput::make('place_of_birth'),
                            Select::make('gender_id')
                                ->label('Gender')
                                ->options(Gender::pluck('name', 'id'))->required(),
                            Select::make('blood_type')->options([
                                'A' => 'A',
                                'B' => 'B',
                                'AB' => 'AB',
                                'O' => 'O',
                            ]),
                            TextInput::make('religion'),
                            Select::make('status')->options([
                                MemberInformation::STATUS_ACTIVE => 'Active',
                                MemberInformation::STATUS_DECEASED => 'Deceased',
                                MemberInformation::STATUS_INACTIVE => 'Inactive',
                            ])->required(),
                            TextInput::make('percentage')->required()->numeric()->minValue(0)->maxValue(100),
                        ])
                    ])
                    ->color('success')
                    ->button(),
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
            ])
        ];
    }

    protected function getHistoryRoute(Model $record)
    {
        return '#';
    }

    protected function getMemberRestrictionsRoute(Model $record)
    {
        return '#';
    }

    public function render()
    {
        return view('livewire.shared.member-management');
    }
}
