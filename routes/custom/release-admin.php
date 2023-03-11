<?php

use App\Http\Controllers\ReportsDownloadController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Shared\MemberDividends;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminDashboard;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminRegisterMember;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminUserManagement;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminMemberManagement;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminClusterManagement;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminFreeLotHistory;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminFreeLotManagement;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminManageProofOfRelease;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminReleaseManagement;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminTransactionsHistory;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminMemberRestrictionsManagement;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminReleaseDividends;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminReportsIndex;

Route::middleware(['auth', 'role:' . Role::RELEASE_ADMIN])->prefix('release-admin')->name('release-admin.')->group(function () {
    Route::get('/', ReleaseAdminDashboard::class)->name('dashboard');
    Route::get('/manage-members', ReleaseAdminMemberManagement::class)->name('manage-members');
    Route::get('/register-members', ReleaseAdminRegisterMember::class)->name('register-members');
    Route::get('/manage-users', ReleaseAdminUserManagement::class)->name('manage-users');
    Route::get('/manage-releases', ReleaseAdminReleaseManagement::class)->name('manage-releases');
    Route::get('/manage-member-restrictions/{member}', ReleaseAdminMemberRestrictionsManagement::class)->name('manage-member-restrictions');
    Route::get('/manage-clusters', ReleaseAdminClusterManagement::class)->name('manage-clusters');
    Route::get('/transactions', ReleaseAdminTransactionsHistory::class)->name('transactions');
    Route::get('/releases/{release}/dividends', ReleaseAdminReleaseDividends::class)->name('releases.dividends');
    Route::get('/member-dividends/{member}', MemberDividends::class)->name('member-dividends');
    Route::get('/reports', ReleaseAdminReportsIndex::class)->name('reports');
    Route::get('/manage-proof-of-release/{dividend}', ReleaseAdminManageProofOfRelease::class)->name('manage-proof-of-release');
    Route::get('/free-lots', ReleaseAdminFreeLotManagement::class)->name('manage-free-lots');
    Route::get('/free-lots/{free_lot}/history', ReleaseAdminFreeLotHistory::class)->name('free-lot-history');

    Route::prefix('download-report')->name('download-report.')->group(function () {
        Route::get('/released/{release}/status/{status}', [ReportsDownloadController::class, 'releasesByStatus'])->name('releases-by-status');
        Route::get('/voided-releases/{release}', [ReportsDownloadController::class, 'voidedReleases'])->name('voided-releases');
        Route::get('/releases-by-cashier/{cashier}', [ReportsDownloadController::class, 'releasesByCashier'])->name('releases-by-cashier');
        Route::get('/voided-releases-by-cashier/{cashier}', [ReportsDownloadController::class, 'voidedReleasesByCashier'])->name('voided-releases-by-cashier');
        Route::get('/claimed-releases-by-type/{release}', [ReportsDownloadController::class, 'claimedReleasesByType'])->name('claimed-releases-by-type');
    });
});
