<?php

namespace App\Http\Livewire\Cashier;

use App\Models\Release;
use Filament\Tables\Actions\Action;
use Livewire\Component;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;

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
            TextColumn::make('created_at')
                ->label('Date Released')
                ->date('F d, Y'),
            TextColumn::make('name'),
            TextColumn::make('total_amount')
                ->label('Total Amount')
                ->money('PHP', true),
            TagsColumn::make('particulars')
                ->getStateUsing(fn ($record) => collect($record->particulars)->map(fn ($value, $key) => $key)->toArray()),
            IconColumn::make('disbursed')
                ->alignCenter()
                ->extraAttributes(['class' => 'flex justify-center'])
                ->boolean(),
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
            Action::make('daily_cash')
                ->outlined()
                ->button()
                ->icon('heroicon-o-cash')
                ->url(fn ($record) => route('cashier.daily-cash', ['release' => $record]))
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
