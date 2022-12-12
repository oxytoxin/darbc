<?php

namespace App\Http\Livewire\Cashier;

use App\Models\Dividend;
use Livewire\Component;

class CashierPrintPayslip extends Component
{
    public Dividend $dividend;

    public function render()
    {
        return view('livewire.cashier.cashier-print-payslip');
    }
}
