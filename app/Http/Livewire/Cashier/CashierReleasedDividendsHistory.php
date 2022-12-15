<?php

namespace App\Http\Livewire\Cashier;

use Livewire\Component;
use App\Models\Dividend;
use App\Models\User;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Concerns\InteractsWithTable;

class CashierReleasedDividendsHistory extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery()
    {
        return Dividend::with('user.member_information')->whereNotNull('released_by')->latest('released_at');
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('user.member_information.darbc_id')
                ->label('DARBC ID')
                ->searchable(),
            TextColumn::make('cashier.full_name')
                ->label('Cashier'),
            TextColumn::make('user.surname')
                ->label('Member Last Name')
                ->searchable(isIndividual: true),
            TextColumn::make('user.first_name')
                ->label('Member First Name')
                ->searchable(isIndividual: true),
            TextColumn::make('released_at')
                ->label('Release Date')
                ->dateTime('h:i A m/d/Y'),
        ];
    }

    protected function getTableActions()
    {
        return [
            Action::make('Payslip')
                ->icon('heroicon-o-document-report')
                ->button()
                ->url(fn (Dividend $record) => route('cashier.dividends.payslip', ['dividend' => $record])),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('released_by')
                ->label('Cashier')
                ->placeholder('All')
                ->options(User::whereRelation('roles', 'name', 'cashier')->get()->pluck('full_name', 'id')),
        ];
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    public function render()
    {
        return view('livewire.cashier.cashier-released-dividends-history');
    }
}
