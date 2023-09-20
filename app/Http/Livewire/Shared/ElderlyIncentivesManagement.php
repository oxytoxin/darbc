<?php

namespace App\Http\Livewire\Shared;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Models\ElderlyIncentive;
use App\Models\MemberInformation;
use App\Models\MembershipStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Component;

class ElderlyIncentivesManagement extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery(): Builder|Relation
    {
        return ElderlyIncentive::query();
    }



    protected function getTableHeaderActions(): array
    {
        return [
            FilamentExportHeaderAction::make('export')
                ->directDownload()
                ->fileNamePrefix('Elderly Incentives Awarded')
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('user.member_information.darbc_id')
                ->searchable()
                ->sortable(true, function ($query, $direction) {
                    $query
                        ->leftJoin('users', 'elderly_incentives.user_id', '=', 'users.id')
                        ->leftJoin('member_information', 'users.id', '=', 'member_information.user_id')
                        ->selectRaw('elderly_incentives.*, member_information.darbc_id as member_darbc_id')
                        ->orderBy('member_darbc_id', $direction);
                })
                ->label('DARBC ID'),
            TextColumn::make('user.alt_full_name')
                ->searchable()
                ->sortable()
                ->label('Member Name'),
            TextColumn::make('amount')
                ->money('PHP', true)
                ->sortable(),
            TextColumn::make('created_at')
                ->date()
                ->sortable()
                ->label('Date Awarded')
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Filter::make('date')
                ->columns(2)
                ->columnSpan(2)
                ->form([
                    DatePicker::make('date_from'),
                    DatePicker::make('date_to'),
                ])
                ->query(function (Builder $query, $data) {
                    $query
                        ->when($data['date_from'], fn ($query, $value) => $query->whereDate('created_at', '>=', $value))
                        ->when($data['date_to'], fn ($query, $value) => $query->whereDate('created_at', '<=', $value));
                }),
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
                            $query->whereRelation('user', fn ($query) => $query->whereRelation('member_information', fn ($query) => $query->whereStatus(MemberInformation::STATUS_ACTIVE)));
                            break;
                        case 'original':
                            $query->whereRelation('user', fn ($query) => $query->whereRelation('member_information', fn ($query) => $query->whereMembershipStatusId(MembershipStatus::ORIGINAL)));
                            break;
                        case 'replacement':
                            $query->whereRelation('user', fn ($query) => $query->whereRelation('member_information', fn ($query) => $query->whereMembershipStatusId(MembershipStatus::REPLACEMENT)));
                            break;
                        case 'deceased':
                            $query->whereRelation('user', fn ($query) => $query->whereRelation('member_information', fn ($query) => $query->whereStatus(MemberInformation::STATUS_DECEASED)));
                            break;
                        default:
                            break;
                    }
                }),
        ];
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    protected function getTableActions(): array
    {
        return [
            DeleteAction::make(),
            EditAction::make()
                ->form(fn ($record) => [
                    DatePicker::make('created_at')
                        ->label('Date Awarded')
                ]),
            ViewAction::make('print')
                ->label('Template')
                ->color('success')
                ->icon('heroicon-o-printer')
                ->button()
                ->outlined()
                ->modalContent(fn ($record) => view('livewire.release-admin.components.request-for-payment', ['incentive' => $record]))
                ->modalHeading('Request for Payment'),
        ];
    }

    public function render()
    {
        return view('livewire.shared.elderly-incentives-management');
    }
}
