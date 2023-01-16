<?php

namespace App\Http\Livewire\Cashier;

use App\Models\Dividend;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CashierPrintPayslip extends Component
{
    use AuthorizesRequests;
    public Dividend $dividend;

    public function mount()
    {
        $this->authorize('payslip', $this->dividend);
    }

    public function render()
    {
        return view('livewire.cashier.cashier-print-payslip');
    }
}
