<?php

namespace App\Http\Livewire\Shared;

use Closure;
use App\Models\Gender;
use Livewire\Component;
use App\Models\MembershipStatus;
use App\Models\MemberInformation;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Concerns\InteractsWithTable;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

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
            BadgeColumn::make('missing_details_count')
                ->label('Missing Details')
                ->tooltip(fn ($record) => implode(", ", $record->missing_details->toArray()))
                ->extraAttributes(['class' => 'cursor-pointer'])
                ->alignCenter()
                ->color(fn ($state) => $state > 0 ? 'warning' : 'success'),

        ];
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
                            $query->whereMembershipStatusId(MembershipStatus::ORIGINAL);
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
                ->columnSpan(2)
        ];
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    protected function getTableActions()
    {
        return [
            Action::make('profile')
                ->button()
                ->icon('heroicon-o-user')
                ->url(fn ($record) => $this->getProfileRoute($record)),
            Action::make('claims')
                ->button()
                ->outlined()
                ->icon('heroicon-o-cash')
                ->url(fn ($record) => $this->getMemberClaimsRoute($record)),
            ActionGroup::make([
                EditAction::make('edit')
                    ->url(fn ($record) => route('release-admin.manage-members.edit', ['member' => $record]))
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
                            if ($record->user->dividends()->count()) {
                                return notify('Unable to delete member with existing dividends.', type: 'danger');
                            }
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

    protected function getProfileRoute(Model $record)
    {
        return '#';
    }

    protected function getMemberClaimsRoute(Model $record)
    {
        return '#';
    }

    public function getExportRoute()
    {
        return '#';
    }

    public function getAddMemberRoute()
    {
        return '#';
    }

    public function render()
    {
        return view('livewire.shared.member-management');
    }
}
