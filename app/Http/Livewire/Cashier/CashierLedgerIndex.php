<?php

namespace App\Http\Livewire\Cashier;

use App\Models\User;
use Livewire\Component;
use App\Models\MemberInformation;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Concerns\InteractsWithTable;

class CashierLedgerIndex extends Component implements HasTable
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
                ->searchable(),
            TextColumn::make('user.full_name')
                ->searchable(query: fn ($query, $search) => $query->orWhereRelation('user', 'surname', 'like',  "$search%"))
                ->label('Name'),
            BadgeColumn::make('succession_number')
                ->colors([
                    'success'
                ])
                ->formatStateUsing(fn ($state) => $state == '0' ? 'Original Owner' : ordinal($state) . ' Successor')
                ->label('Ownership'),

        ];
    }

    protected function getTableActions()
    {
        return [
            Action::make('view')
                ->button()
                ->color('success')
                ->url(fn ($record) => route('cashier.member-dividends', ['member' => $record]))
        ];
    }

    public function render()
    {
        return view('livewire.cashier.cashier-ledger-index');
    }
}
