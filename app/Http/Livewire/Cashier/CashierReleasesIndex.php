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
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;

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

    protected function getTableHeaderActions()
    {
        return [
            Action::make('test_printer')
                ->label('Test Printer')
                ->button()
                ->color('primary')
                ->action(function () {
                    $this->testPrinter();
                })
        ];
    }

    public function testPrinter()
    {
        $printerIp = auth()->user()->ip_address;
        $printerPort = 9100;
        $connector = new NetworkPrintConnector($printerIp);
        $printer = new Printer($connector);
        try {
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text(auth()->user()->name);
            $printer->feed(4);
            $printer->text("Printer is good to go!");
            $printer->feed(4);
            $printer->cut();
            $printer->close();
        } finally {
            $printer->close();
        }
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
                ->visible(fn ($record) => $record->disbursed)
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
