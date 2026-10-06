<?php

namespace App\Http\Livewire\Rsbsa;

use Livewire\Component;
use App\Models\RsbsaRecord;
use App\Models\MembershipStatus;
use App\Models\MemberInformation;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\ActionGroup;
use Filament\Notifications\Notification;

use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Concerns\InteractsWithTable;

class RsbsaMemberManagement extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery()
    {
        // Eager load the RSBSA record: the status and missing-details columns both
        // read it per row, which would otherwise be one query per member.
        return MemberInformation::query()->with('rsbsa');
    }
    protected function getDefaultTableSortDirection(): ?string
    {
        return 'asc';
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'darbc_id';
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5, 10, 25, 50];
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('darbc_id')
                ->label('DARBC ID')
                ->sortable()
                ->searchable(),
            TextColumn::make('user.surname')
                ->label('Last Name')
                ->sortable()
                ->searchable(isIndividual: true),
            TextColumn::make('user.first_name')
                ->label('First Name')
                ->searchable(isIndividual: true),
            BadgeColumn::make('succession_number')
                ->colors([
                    'success'
                ])
                ->sortable()
                ->formatStateUsing(fn ($state) => $state == 0 ? 'Original' : ordinal($state) . ' Successor')
                ->label('Ownership'),
            TextColumn::make('application_date')
                ->label('Member since')
                ->date(),

            BadgeColumn::make('application_status')
                ->label('Application Status')
                ->getStateUsing(fn ($record) => $record->rsbsa
                    ? $record->rsbsa->applicationStatusLabel()
                    : 'Not Registered')
                ->colors([
                    'secondary',
                    'warning' => RsbsaRecord::APPLICATION_STATUSES[RsbsaRecord::STATUS_FOR_TRANSMITTAL],
                    'primary' => RsbsaRecord::APPLICATION_STATUSES[RsbsaRecord::STATUS_TRANSMITTED],
                    'success' => RsbsaRecord::APPLICATION_STATUSES[RsbsaRecord::STATUS_COMPLETED],
                    'danger' => fn ($state) => in_array($state, [
                        RsbsaRecord::APPLICATION_STATUSES[RsbsaRecord::STATUS_PENDING_REQUIREMENTS],
                        RsbsaRecord::APPLICATION_STATUSES[RsbsaRecord::STATUS_RETURNED],
                    ]),
                ]),

                ViewColumn::make('rsbsa_missing_details')->view('tables.columns.rsbsa.rsbsa-missing-details')->label('Missing RSBSA Details')   ->tooltip(function ($record){
                    if($record->rsbsa){
                        return implode(", ", $record->rsbsa->missingDetails->toArray());
                    }
                    return '';
                })

                // BadgeColumn::make('rsbsa.missing_details_count')
                // ->label('Missing RSBSA Details')
                // ->tooltip(fn ($record) => implode(", ", $record->missing_details->toArray()))



        ];
    }
    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('membership_status_id')
                ->label('Membership')
                ->placeholder('All')
                ->options([
                    'active' => 'ACTIVE',
                    'original' => 'ORIGINAL',
                    'replacement' => 'REPLACEMENT',
                    'deceased' => 'DECEASED',
                ])
                ->default('active')
                ->query(function ($query, $data) {
                    switch ($data['value']) {
                        case 'active':
                            $query->whereStatus(MemberInformation::STATUS_ACTIVE);
                            break;
                        case 'original':
                            $query->original();
                            break;
                        case 'replacement':
                            $query->whereMembershipStatusId(MembershipStatus::REPLACEMENT);
                            break;
                        case 'deceased':
                            $query->whereStatus(MemberInformation::STATUS_DECEASED);
                            break;
                        default:
                            break;
                    }
                }),
            Filter::make('application_date')
                ->form([
                    DatePicker::make('from')
                        ->withoutTime(),
                    DatePicker::make('to')
                        ->withoutTime(),
                ])
                ->query(function ($query, $data) {
                    $query
                        ->when($data['from'], fn ($query, $from) => $query->whereDate('application_date', '>=', $from))
                        ->when($data['to'], fn ($query, $to) => $query->whereDate('application_date', '<=', $to));
                })
                ->columns(2)
                ->columnSpan(2),
                SelectFilter::make('rsbsa_status')
            ->label('RSBSA Status')
            ->placeholder('All')
            ->options([
                'with_rsbsa' => 'With RSBSA',
                'without_rsbsa' => 'Without RSBSA',
            ])
            ->query(function ($query, $data) {
                if ($data['value'] === 'with_rsbsa') {
                    $query->whereHas('rsbsa'); // Members who have an RSBSA record
                } elseif ($data['value'] === 'without_rsbsa') {
                    $query->whereDoesntHave('rsbsa'); // Members who don't have an RSBSA record
                }
            }),
            SelectFilter::make('application_status')
                ->label('Application Status')
                ->placeholder('All')
                ->options(RsbsaRecord::APPLICATION_STATUSES + ['not_set' => 'Not Set'])
                ->query(function ($query, $data) {
                    if (blank($data['value'])) {
                        return;
                    }

                    $status = $data['value'] === 'not_set' ? null : $data['value'];

                    $query->whereHas('rsbsa', fn ($rsbsa) => $status === null
                        ? $rsbsa->whereNull('application_status')
                        : $rsbsa->where('application_status', $status));
                }),
        ];
    }


    protected function getTableActions()
    {
        return [
            Action::make('RSBSA')
            ->label('Register this MEMBER')
                ->button()
                ->icon('heroicon-o-user')
                ->url(fn ($record): string => route('rsbsa.register', ['member' => $record]))
                ->hidden(fn($record)=> $record->hasRsbsaRecord())
                ,

                Action::make('Edit RSBSA')
    ->label('Edit RSBSA')
    ->button()
    ->icon('heroicon-o-pencil')
    ->url(fn ($record): string => route('rsbsa.edit', ['rsbsa' => $record->rsbsa]))
    ->hidden(fn($record) => !$record->hasRsbsaRecord()),
            Action::make('View')
            ->label('View RSBSA')
                ->button()
                ->outlined()
                ->icon('heroicon-o-document-text')
                ->url(fn ($record): string => route('rsbsa.view', ['rsbsa' => $record->rsbsa]))
                ->openUrlInNewTab()
                ->hidden(fn($record) => !$record->hasRsbsaRecord())
                ,

            Action::make('Set Status')
                ->label('Set Status')
                ->button()
                ->outlined()
                ->icon('heroicon-o-flag')
                ->modalHeading('Set Application Status')
                ->modalButton('Save')
                ->hidden(fn ($record) => !$record->hasRsbsaRecord())
                ->mountUsing(fn ($form, $record) => $form->fill([
                    'application_status' => $record->rsbsa->application_status,
                ]))
                ->form([
                    Select::make('application_status')
                        ->label('Application Status')
                        ->options(RsbsaRecord::APPLICATION_STATUSES)
                        ->required(),
                ])
                ->action(function ($record, array $data) {
                    $record->rsbsa->update(['application_status' => $data['application_status']]);

                    Notification::make()
                        ->title('Application status updated')
                        ->body($record->rsbsa->applicationStatusLabel())
                        ->success()
                        ->send();
                }),

                ActionGroup::make([

                    ])
        ];
    }

    public function render()
    {
        return view('livewire.rsbsa.rsbsa-member-management');
    }
}
