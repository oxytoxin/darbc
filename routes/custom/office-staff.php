<?php

use App\Http\Livewire\OfficeStaff\OfficeStaffDashboard;
use App\Http\Livewire\OfficeStaff\OfficeStaffLedgerIndex;
use App\Http\Livewire\OfficeStaff\OfficeStaffMemberManagement;
use App\Http\Livewire\OfficeStaff\OfficeStaffMemberRestrictionsManagement;
use App\Http\Livewire\OfficeStaff\OfficeStaffRegisterMember;
use App\Http\Livewire\OfficeStaff\OfficeStaffReleaseDetailsManagement;
use App\Http\Livewire\OfficeStaff\OfficeStaffReleaseDividendsManagement;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('office-staff')->name('office-staff.')->group(function () {
    Route::get('/', OfficeStaffDashboard::class)->name('dashboard');
    Route::get('/manage-members', OfficeStaffMemberManagement::class)->name('manage-members');
    Route::get('/register-members', OfficeStaffRegisterMember::class)->name('register-members');
    Route::get('/manage-member-restrictions/{member}', OfficeStaffMemberRestrictionsManagement::class)->name('manage-member-restrictions');
    Route::get('/ledger', OfficeStaffLedgerIndex::class)->name('ledger.index');
    Route::get('/release-dividends/{release}', OfficeStaffReleaseDividendsManagement::class)->name('ledger.release-dividends');
    Route::get('/release-details/{release}', OfficeStaffReleaseDetailsManagement::class)->name('ledger.release-details');
});
