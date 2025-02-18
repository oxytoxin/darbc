<?php

namespace App\Http\Livewire\Rsbsa;

use Livewire\Component;
use App\Models\MembershipStatus;
use App\Models\MemberInformation;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Concerns\InteractsWithTable;

use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;

class RsbsaMemberManagement extends Component implements HasTable
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
                ->icon('heroicon-o-cash')
                ->url(fn ($record): string => route('rsbsa.view', ['rsbsa' => $record->rsbsa]))
                ->hidden(fn($record) => !$record->hasRsbsaRecord())
                ,


                ActionGroup::make([

                    ])
        ];
    }

    public function render()
    {
        return view('livewire.rsbsa.rsbsa-member-management');
    }
}
