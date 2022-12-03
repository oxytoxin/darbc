<?php

namespace App\Http\Livewire\Cashier;

use Livewire\Component;
use App\Models\Dividend;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;

class CashierReleasedDividendsHistory extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery()
    {
        return Dividend::with('user.member_information')->whereStatus(Dividend::RELEASED)->whereReleasedBy(auth()->id());
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('user.member_information.darbc_id')
                ->label('DARBC ID')
                ->searchable(),
            TextColumn::make('user.full_name')
                ->label('Name')
                ->searchable(['first_name', 'surname'])
                ->sortable(['surname']),
            TextColumn::make('gross_amount')
                ->sortable()
                ->label('Gross')
                ->money('PHP', true),
            TextColumn::make('deductions_amount')
                ->sortable()
                ->label('Deductions')
                ->money('PHP', true),
            TextColumn::make('net_amount')
                ->label('Net')
                ->money('PHP', true),
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

    public function render()
    {
        return view('livewire.cashier.cashier-released-dividends-history');
    }
}
