<?php

use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportsDownloadController;
use App\Http\Livewire\OfficeStaff\OfficeStaffDashboard;
use App\Http\Livewire\OfficeStaff\OfficeStaffLedgerIndex;
use App\Http\Livewire\OfficeStaff\OfficeStaffRegisterMember;
use App\Http\Livewire\OfficeStaff\OfficeStaffMemberManagement;
use App\Http\Livewire\OfficeStaff\OfficeStaffFreeLotManagement;
use App\Http\Livewire\OfficeStaff\OfficeStaffMemberProfile;
use App\Http\Livewire\OfficeStaff\OfficeStaffReleaseDetailsManagement;
use App\Http\Livewire\OfficeStaff\OfficeStaffReleaseDividendsManagement;
use App\Http\Livewire\OfficeStaff\OfficeStaffReleasesIndex;
use App\Http\Livewire\OfficeStaff\OfficeStaffUpdateMemberInformation;
use App\Http\Livewire\Shared\MemberClaims;

Route::middleware(['auth', 'role:' . Role::OFFICE_STAFF])->prefix('office-staff')->name('office-staff.')->group(function () {
    Route::get('/', OfficeStaffDashboard::class)->name('dashboard');
    Route::get('/manage-members', OfficeStaffMemberManagement::class)->name('manage-members');
    Route::get('/manage-members/{member}/edit', OfficeStaffUpdateMemberInformation::class)->name('manage-members.edit');
    Route::get('/register-members', OfficeStaffRegisterMember::class)->name('register-members');
    Route::get('/manage-member-claims/{member}', MemberClaims::class)->name('manage-member-claims');
    Route::get('/releases', OfficeStaffReleasesIndex::class)->name('releases.index');
    Route::get('/ledger', OfficeStaffLedgerIndex::class)->name('ledger.index');
    Route::get('/release-dividends/{release}', OfficeStaffReleaseDividendsManagement::class)->name('ledger.release-dividends');
    Route::get('/release-details/{release}', OfficeStaffReleaseDetailsManagement::class)->name('ledger.release-details');
    Route::get('/member-profile/{member}', OfficeStaffMemberProfile::class)->name('member-profile');
    Route::get('/free-lots', OfficeStaffFreeLotManagement::class)->name('manage-free-lots');
    Route::prefix('download-report')->name('download-report.')->group(function () {
        Route::get('/members', [ReportsDownloadController::class, 'members'])->name('members');
    });
});
