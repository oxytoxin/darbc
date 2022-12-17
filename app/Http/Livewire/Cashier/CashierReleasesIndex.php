<?php

namespace App\Http\Livewire\Cashier;

use App\Models\Release;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class CashierReleasesIndex extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery()
    {
        return Release::query();
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('total_amount')
                ->sortable()
                ->label('Total Amount')
                ->money('PHP', true),
            IconColumn::make('disbursed')
                ->label('Disbursed By Office Staff')
                ->boolean(),
            TextColumn::make('created_at')
                ->sortable()
                ->label('Date Created')
                ->date('F d, Y'),
        ];
    }

    protected function getTableActions()
    {
        return [
            ViewAction::make('view')
                ->button()
                ->color('success')
                ->visible(fn ($record) => $record->disbursed)
                ->url(fn ($record) => route('cashier.releases.dividends', ['release' => $record])),
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    public function render()
    {
        return view('livewire.cashier.cashier-releases-index');
    }
}
