<?php

namespace App\Http\Livewire\Cashier;

use App\Models\Payslip;
use Livewire\Component;
use Mike42\Escpos\Printer;
use App\Models\PayslipEntry;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\HtmlString;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Throwable;

class CashierPayslipEntries extends Component implements HasTable
{
    use InteractsWithTable;

    public Payslip $payslip;

    protected function getTableQuery(): Builder|Relation
    {
        return PayslipEntry::query()->where('payslip_id', $this->payslip->id);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('darbc_id')->label('DARBC ID')->searchable(),
            TextColumn::make('member_name')->searchable(),
            TextColumn::make('payslip.release.name'),
            TextColumn::make('full_gc_number')->label('GC #'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            EditAction::make()
                ->label('Gift Certificate Number')
                ->form([
                    TextInput::make('gc_number')->label('GC #')
                ]),
            ViewAction::make('view')
                ->requiresConfirmation()
                ->icon('heroicon-o-document')
                ->button()
                ->modalContent(function ($record) {
                    return view('livewire.cashier.components.payslip_new', ['payslip_entry' => $record]);
                })
                ->modalWidth('4xl')
                ->modalHeading(false)
                ->modalSubheading(false),
            Action::make('print')
                ->requiresConfirmation()
                ->icon('heroicon-o-printer')
                ->button()
                ->action(function ($record) {
                    $this->printPayslip($record, "MEMBER'S COPY");
                    sleep(1);
                    $this->printPayslip($record, "DARBC COPY");
                })
        ];
    }

    protected function getTableHeaderActions(): array
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
        try {
            $printerIp = auth()->user()->ip_address;
            $printerPort = 9100;
            $connector = new NetworkPrintConnector($printerIp);
            $printer = new Printer($connector);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text(auth()->user()->name);
            $printer->feed(4);
            $printer->text("Printer is good to go!");
            $printer->feed(4);
            $printer->cut();
            $printer->close();
        } catch (Throwable $e) {
            Notification::make()->title('Failed to connect to printer.')->danger()->send();
        }
    }

    public function printPayslip($payslip_entry, $title = "MEMBER'S COPY")
    {
        $printerIp =  auth()->user()->ip_address;
        if (!$printerIp) {
            return Notification::make()->title('Printer IP not found.')->warning()->send();
        }
        $printerPort = 9100;
        $connector = new NetworkPrintConnector($printerIp, $printerPort, 10);
        $printer = new Printer($connector);
        try {
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text("Dolefil Agrarian Reform\n");
            $printer->text("Beneficiaries Cooperative\n");
            $printer->text("(DARBC)\n");
            $printer->feed(2);
            $printer->text("Payslip\n");
            $printer->text("$title\n");
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Name: " . $payslip_entry->member_name);
            $printer->feed(1);
            $printer->setEmphasis(false);
            $printer->text("Date : " .  now()->format('m/d/Y'));
            $printer->feed(1);
            $printer->text("Time : " .  now()->format('h:i A'));
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text($payslip_entry->payslip->release->name . "\n");
            $printer->setEmphasis(false);
            $printer->feed(1);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            foreach ($payslip_entry->content['items'] as $key => $data) {
                $printer->text($data['title'] . "\n");
                $printer->feed(1);
                foreach ($data['entries'] as $key => $entry) {
                    $printer->text($entry['title'] . ":  " . ($entry['amount'] ?? 'none') . "\n");
                    $printer->feed(1);
                }
                $printer->text("------------\n");
                $printer->feed(1);
                $printer->text($data['total']['title'] . ":  " . ($data['total']['amount'] ?? 'none') . "\n");
                $printer->feed(1);
                $printer->feed(1);
            }
            $printer->feed(1);
            $printer->text("------------\n");
            $printer->text("Grand Total:  " . (collect($payslip_entry->content['items'])->sum('total.amount')) . "\n");
            $printer->feed(1);
            $printer->text("------------\n");
            $printer->feed(1);
            foreach ($payslip_entry->content['extra'] as $key => $data) {
                $printer->text($data['title'] . ":  " . ($data['amount'] ?? 'none') . "\n");
                $printer->feed(1);
                if ($data['title'] == 'Gift Certificate') {
                    $printer->text("GC #:  " . $payslip_entry->full_gc_number . "\n");
                    $printer->feed(1);
                }
            }
            $printer->feed(2);
            $printer->setEmphasis(true);
            $printer->text("TELLER NAME:  " . auth()->user()->first_name . " " . auth()->user()->surname . "\n");
            $printer->feed(4);
            $printer->text("MEMBER'S SIGNATURE:   ");
            $printer->feed(4);
            $printer->text("------------\n");
            $printer->feed(1);
            $printer->cut();
            $printer->close();
        } finally {
            $printer->close();
        }
    }

    public function render()
    {
        return view('livewire.cashier.cashier-payslip-entries');
    }
}
