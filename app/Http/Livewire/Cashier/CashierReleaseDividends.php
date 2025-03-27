<?php

namespace App\Http\Livewire\Cashier;

use Livewire\Component;
use App\Models\Dividend;
use App\Models\MemberInformation;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Http\Livewire\Shared\ReleaseDividends;
use Exception;
use Filament\Notifications\Notification;
use Filament\Tables\Concerns\InteractsWithTable;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;

class CashierReleaseDividends extends ReleaseDividends
{
    public $printer_ip;

    protected function shouldPersistTableFiltersInSession(): bool
    {
        return true;
    }

    public function printPayslipMember($dividend)
    {
        if ($dividend->claimed) {
            $net_amount = 'Php' . number_format($dividend->net_amount, 2);
        } else {
            $net_amount = 'UNCLAIMED';
        }

        $claim_type_name = match ($dividend->claim_type) {
            1 => 'MEMBER',
            2 => 'SPA',
            3 => 'REPRESENTATIVE',
            default => 'MEMBER',
        };
        $printerIp = $this->printer_ip;
        $printerPort = 9100;

        try {
            $connector = new NetworkPrintConnector($printerIp, $printerPort, 10);
            $printer = new Printer($connector);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text("Dolefil Agrarian Reform\n");
            $printer->text("Beneficiaries Cooperative\n");
            $printer->text("(DARBC)\n");
            $printer->feed(2);
            $printer->text("MEMBERS COPY\n");
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Member ID : " . $dividend->user->member_information->darbc_id);
            $printer->feed(1);
            $printer->text("Member's Name: " . $dividend->user->full_name);
            $printer->feed(1);
            $printer->setEmphasis(false);
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text($dividend->release->name . "\n");
            $printer->setEmphasis(false);
            $printer->feed(1);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            if (filled($dividend->breakdown)) {
                foreach ($dividend->breakdown['add'] as $key => $item) {
                    $printer->text($item['name'] . ":  " . number_format($item['value'], 2) . "\n");
                }
                $printer->feed(1);
                $printer->text("LESS: \n");
                foreach ($dividend->breakdown['less'] as $key => $item) {
                    $printer->text($item['name'] . ":  " . number_format($item['value'], 2) . "\n");
                }
                $printer->feed(1);
                $printer->text("NET PAY:  " . $net_amount);
            } else {
                $printer->text("GROSS AMOUNT:  " . number_format($dividend->gross_amount, 2) . "\n");
                $printer->text("TOTAL DEDUCTIONS:  " . number_format($dividend->deductions_amount, 2) . "\n");
                $printer->text($dividend->release->share_description . ":  " . $net_amount . "\n");
            }
            $printer->feed(1);
            if (!$dividend->user->member_information->split_claim && ($dividend->release->gift_certificate_prefix || $dividend->release->gift_certificate_amount > 0)) {
                $gift_certificate_number = $dividend->gift_certificate_control_number ? $dividend->release->gift_certificate_prefix . $dividend->gift_certificate_control_number : 'UNCLAIMED';
                $printer->text("Gift Certificate (worth " . 'Php' . number_format($dividend->release->gift_certificate_amount, 2) . ") :\n");
                $printer->text($gift_certificate_number);
                $printer->feed(2);
            }
            $printer->feed(2);
            $printer->text("Giveaways:");
            $printer->feed(1);
            foreach ($dividend->particulars as $key => $value) {
                $printer->text($value['name'] . "  ");
                if ($value['claimed']) {
                    $printer->text($dividend->release->particulars[$value['name']] ?? "");
                } else {
                    $printer->text('UNCLAIMED');
                }
                $printer->feed(1);
            }
            $printer->feed(1);
            $printer->text("TELLER NAME:  " . $dividend->cashier->first_name . ' ' . $dividend->cashier->surname . "\n");
            $printer->feed(1);
            $printer->text("Date : " . $dividend->released_at->format('m/d/Y'));
            $printer->feed(1);
            $printer->text("Time : " . $dividend->released_at->format('h:i A'));
            $printer->feed(1);
            $printer->text("Bank : " . $dividend->bank);
            $printer->feed(1);
            $printer->text("Cheque No. : " . $dividend->cheque_number);
            $printer->feed(4);
            $printer->text($claim_type_name . "'S SIGNATURE:   ");
            $printer->setEmphasis(true);
            // $printer -> text($member_name."\n");
            if ($dividend->claimed_by) {
                $printer->text(strtoupper($dividend->claimed_by));
            } else {
                $printer->text(strtoupper($dividend->user->full_name));
            }
            $printer->setEmphasis(false);
            $printer->feed(2);
            $printer->cut();
            $printer->close();
        } catch (Exception $e) {
            Notification::make()->title($e->getMessage())->danger()->send();
        }
    }

    public function printPayslipDARBC($dividend)
    {
        if ($dividend->claimed) {
            $net_amount = 'Php' . number_format($dividend->net_amount, 2);
        } else {
            $net_amount = 'UNCLAIMED';
        }

        $claim_type_name = match ($dividend->claim_type) {
            1 => 'MEMBER',
            2 => 'SPA',
            3 => 'REPRESENTATIVE',
            default => 'MEMBER',
        };
        $printerIp = $this->printer_ip;
        $printerPort = 9100;

        try {
            $connector = new NetworkPrintConnector($printerIp, $printerPort, 10);
            $printer = new Printer($connector);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text("Dolefil Agrarian Reform\n");
            $printer->text("Beneficiaries Cooperative\n");
            $printer->text("(DARBC)\n");
            $printer->feed(2);
            $printer->text("DARBC COPY\n");
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Member ID : " . $dividend->user->member_information->darbc_id);
            $printer->feed(1);
            $printer->text("Member's Name: " . $dividend->user->full_name);
            $printer->feed(1);
            $printer->setEmphasis(false);
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text($dividend->release->name . "\n");
            $printer->setEmphasis(false);
            $printer->feed(1);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            if (filled($dividend->breakdown)) {
                foreach ($dividend->breakdown['add'] as $key => $item) {
                    $printer->text($item['name'] . ":  " . number_format($item['value'], 2) . "\n");
                }
                $printer->feed(1);
                $printer->text("LESS: \n");
                foreach ($dividend->breakdown['less'] as $key => $item) {
                    $printer->text($item['name'] . ":  " . number_format($item['value'], 2) . "\n");
                }
                $printer->feed(1);
                $printer->text("NET PAY:  " . $net_amount);
            } else {
                $printer->text("GROSS AMOUNT:  " . number_format($dividend->gross_amount, 2) . "\n");
                $printer->text("TOTAL DEDUCTIONS:  " . number_format($dividend->deductions_amount, 2) . "\n");
                $printer->text($dividend->release->share_description . ":  " . $net_amount);
            }
            $printer->feed(1);
            if (!$dividend->user->member_information->split_claim && ($dividend->release->gift_certificate_prefix || $dividend->release->gift_certificate_amount > 0)) {
                $gift_certificate_number = $dividend->gift_certificate_control_number ? $dividend->release->gift_certificate_prefix . $dividend->gift_certificate_control_number : 'UNCLAIMED';
                $printer->text("Gift Certificate (worth " . 'Php' . number_format($dividend->release->gift_certificate_amount, 2) . ") :\n");
                $printer->text($gift_certificate_number);
                $printer->feed(2);
            }
            $printer->feed(2);
            $printer->text("Giveaways:");
            $printer->feed(1);
            foreach ($dividend->particulars as $key => $value) {
                $printer->text($value['name'] . "  ");
                if ($value['claimed']) {
                    $printer->text($dividend->release->particulars[$value['name']] ?? "");
                } else {
                    $printer->text('UNCLAIMED');
                }
                $printer->feed(1);
            }
            $printer->feed(1);
            $printer->text("TELLER NAME:  " . $dividend->cashier->first_name . ' ' . $dividend->cashier->surname . "\n");
            $printer->feed(1);
            $printer->text("Date : " . $dividend->released_at->format('m/d/Y'));
            $printer->feed(1);
            $printer->text("Time : " . $dividend->released_at->format('h:i A'));
            $printer->feed(1);
            $printer->text("Bank : " . $dividend->bank);
            $printer->feed(1);
            $printer->text("Cheque No. : " . $dividend->cheque_number);
            $printer->feed(4);
            $printer->text($claim_type_name . "'S SIGNATURE:   ");
            $printer->setEmphasis(true);
            // $printer -> text($member_name."\n");
            if ($dividend->claimed_by) {
                $printer->text(strtoupper($dividend->claimed_by));
            } else {
                $printer->text(strtoupper($dividend->user->full_name));
            }
            $printer->setEmphasis(false);
            $printer->feed(2);
            $printer->cut();
            $printer->close();
        } catch (Exception $e) {
            Notification::make()->title($e->getMessage())->danger()->send();
        }
    }


    protected function getTableActions()
    {
        return [
            Action::make('release')
                ->button()
                ->label('Release Now')
                ->color('success')
                ->visible(fn($record) => $record->status === Dividend::FOR_RELEASE && !$record->claimed)
                ->url(fn($record) => route('cashier.dividends.manage', ['dividend' => $record])),
            Action::make('reprint_payslip')
                ->button()
                ->label('Reprint Payslip')
                ->color('warning')
                ->icon('heroicon-o-printer')
                ->visible(fn($record) => $record->status === Dividend::RELEASED && $record->claimed)
                ->action(function ($record) {
                    $this->printPayslipMember($record);
                    sleep(1);
                    $this->printPayslipDARBC($record);
                })->requiresConfirmation(),
        ];
    }

    public function mount()
    {
        $this->printer_ip = auth()->user()->ip_address;
    }

    public function render()
    {
        return view('livewire.cashier.cashier-release-dividends');
    }
}
