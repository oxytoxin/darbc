<?php

use App\Http\Livewire\ReleaseAdmin\ReleaseAdminClusterManagement;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminDashboard;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminMemberManagement;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminMemberRestrictionsManagement;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminRegisterMember;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminReleaseManagement;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminTransactionsHistory;
use App\Http\Livewire\ReleaseAdmin\ReleaseAdminUserManagement;
use App\Http\Livewire\Shared\MemberDividends;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('release-admin')->name('release-admin.')->group(function () {
    Route::get('/', ReleaseAdminDashboard::class)->name('dashboard');
    Route::get('/manage-members', ReleaseAdminMemberManagement::class)->name('manage-members');
    Route::get('/register-members', ReleaseAdminRegisterMember::class)->name('register-members');
    Route::get('/manage-users', ReleaseAdminUserManagement::class)->name('manage-users');
    Route::get('/manage-releases', ReleaseAdminReleaseManagement::class)->name('manage-releases');
    Route::get('/manage-member-restrictions/{member}', ReleaseAdminMemberRestrictionsManagement::class)->name('manage-member-restrictions');
    Route::get('/manage-clusters', ReleaseAdminClusterManagement::class)->name('manage-clusters');
    Route::get('/transactions', ReleaseAdminTransactionsHistory::class)->name('transactions');
    Route::get('/member-dividends/{member}', MemberDividends::class)->name('member-dividends');
});
