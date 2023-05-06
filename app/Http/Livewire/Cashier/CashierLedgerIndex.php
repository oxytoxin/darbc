<?php

namespace App\Http\Livewire\Cashier;

use App\Models\User;
use Livewire\Component;
use App\Models\MembershipStatus;
use App\Models\MemberInformation;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Concerns\InteractsWithTable;

class CashierLedgerIndex extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5, 10, 25, 50];
    }

    protected function getTableQuery()
    {
        return MemberInformation::orderBy('darbc_id');
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('darbc_id')
                ->label('DARBC ID')
                ->searchable(),
            TextColumn::make('user.surname')
                ->label('Last Name')
                ->searchable(isIndividual: true),
            TextColumn::make('user.first_name')
                ->label('First Name')
                ->searchable(isIndividual: true),
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
            BadgeColumn::make('succession_number')
                ->colors([
                    'success'
                ])
                ->formatStateUsing(fn ($state) => $state == '0' ? 'Original Owner' : ordinal($state) . ' Successor')
                ->label('Ownership'),

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
            Action::make('view')
                ->button()
                ->visible(fn ($record) => $record->status == MemberInformation::STATUS_ACTIVE)
                ->color('success')
                ->url(fn ($record) => route('cashier.manage-member-claims', ['member' => $record]))
        ];
    }

    public function render()
    {
        return view('livewire.cashier.cashier-ledger-index');
    }
}
