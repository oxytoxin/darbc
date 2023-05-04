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

    // protected function getTableRecordClassesUsing(): ?Closure
    // {
    //     return fn (Model $record) => match ($this->tableFilters['membership_status_id']['value']) {
    //         'active' => 'bg-green-100 border-b border-gray-700',
    //         'original' => 'bg-blue-100 border-b border-gray-700',
    //         'replacement' => 'bg-purple-100 border-b border-gray-700',
    //         default => null,
    //     };
    // }

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
                ->label('Profile')
                ->button()
                ->icon('heroicon-o-user')
                ->url(fn ($record) => $this->getProfileRoute($record)),
            Action::make('restrictions')
                ->label('Restrictions')
                ->button()
                ->outlined()
                ->icon('heroicon-o-lock-closed')
                ->url(fn ($record) => $this->getMemberRestrictionsRoute($record)),
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

    protected function getMemberRestrictionsRoute(Model $record)
    {
        return '#';
    }

    public function render()
    {
        return view('livewire.shared.member-management');
    }
}
