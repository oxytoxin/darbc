<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\Dividend;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class ReleaseAdminTransactionsHistory extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery()
    {
        return Dividend::whereStatus(Dividend::RELEASED);
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('created_at')
                ->label('DATE')
                ->sortable()
                ->dateTime('h:i A, F d, Y'),
            TextColumn::make('user.surname')
                ->label('Last Name')
                ->sortable()
                ->searchable(isIndividual: true),
            TextColumn::make('user.first_name')
                ->label('First Name')
                ->searchable(isIndividual: true),
            TextColumn::make('release.name')
                ->label('RELEASE NAME'),
            TextColumn::make('cashier.full_name')
                ->label('CASHIER')
                ->sortable(['cashier.surname']),
            BadgeColumn::make('status')
                ->label('STATUS')
                ->enum([
                    Dividend::RELEASED => 'released',
                ])
                ->colors([
                    'success',
                ]),
            TextColumn::make('net_amount')
                ->label('AMOUNT')
                ->sortable(['gross_amount'])
                ->money('PHP', true),
        ];
    }

    public function render()
    {
        return view('livewire.release-admin.release-admin-transactions-history');
    }
}
