<?php

use App\Http\Livewire\Cashier\CashierDashboard;
use App\Http\Livewire\Cashier\CashierLedgerIndex;
use App\Http\Livewire\Shared\MemberDividends;
use App\Http\Livewire\Cashier\CashierPrintPayslip;
use App\Http\Livewire\Cashier\CashierReleasedDividendsHistory;
use App\Http\Livewire\Cashier\CashierReleaseDividendManagement;
use App\Http\Livewire\Cashier\CashierReleaseDividends;
use App\Http\Livewire\Cashier\CashierReleasesIndex;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('cashier')->name('cashier.')->group(function () {
    Route::get('/', CashierDashboard::class)->name('dashboard');
    Route::get('/releases', CashierReleasesIndex::class)->name('releases.index');
    Route::get('/releases/{release}/dividends', CashierReleaseDividends::class)->name('releases.dividends');
    Route::get('/dividends/{dividend}/manage', CashierReleaseDividendManagement::class)->name('dividends.manage');
    Route::get('/dividends/{dividend}/payslip', CashierPrintPayslip::class)->name('dividends.payslip');
    Route::get('/history/released-dividends', CashierReleasedDividendsHistory::class)->name('history.released-dividends');
    Route::get('/ledger', CashierLedgerIndex::class)->name('ledger');
    Route::get('/member-dividends/{member}', MemberDividends::class)->name('member-dividends');
});
