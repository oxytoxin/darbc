<?php

use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Shared\MemberClaims;
use App\Http\Livewire\Cashier\CashierDashboard;
use App\Http\Livewire\Cashier\CashierLedgerIndex;
use App\Http\Livewire\Cashier\CashierPrintPayslip;
use App\Http\Livewire\Cashier\CashierReleasesIndex;
use App\Http\Livewire\Cashier\CashierReleaseDividends;
use App\Http\Livewire\Cashier\CashierDailyCashManagement;
use App\Http\Livewire\Cashier\CashierCashMonitoringReport;
use App\Http\Livewire\Cashier\CashierReleasedDividendsHistory;
use App\Http\Livewire\Cashier\CashierReleaseDividendManagement;

Route::middleware(['auth', 'role:' . Role::CASHIER])->prefix('cashier')->name('cashier.')->group(function () {
    Route::get('/', CashierDashboard::class)->name('dashboard');
    Route::get('/releases', CashierReleasesIndex::class)->name('releases.index');
    Route::get('/releases/{release}/dividends', CashierReleaseDividends::class)->name('releases.dividends');
    Route::get('/dividends/{dividend}/manage', CashierReleaseDividendManagement::class)->name('dividends.manage');
    Route::get('/dividends/{dividend}/payslip', CashierPrintPayslip::class)->name('dividends.payslip');
    Route::get('/history/released-dividends', CashierReleasedDividendsHistory::class)->name('history.released-dividends');
    Route::get('/ledger', CashierLedgerIndex::class)->name('ledger');
    Route::get('/manage-member-claims/{member}', MemberClaims::class)->name('manage-member-claims');
    Route::get('/daily-cash/{release}', CashierDailyCashManagement::class)->name('daily-cash');
    Route::get('/cash-monitoring-report/{release}', CashierCashMonitoringReport::class)->name('cash-monitoring-report');
});
