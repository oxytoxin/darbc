<?php

use App\Http\Livewire\Admin\AdminClusterManagement;
use App\Http\Livewire\Admin\AdminDashboard;
use App\Http\Livewire\Admin\AdminMemberManagement;
use App\Http\Livewire\Admin\AdminMemberRestrictionsManagement;
use App\Http\Livewire\Admin\AdminRegisterMember;
use App\Http\Livewire\Admin\AdminReleaseManagement;
use App\Http\Livewire\Admin\AdminTransactionsHistory;
use App\Http\Livewire\Admin\AdminUserManagement;
use App\Http\Livewire\Shared\MemberDividends;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('administrator')->name('administrator.')->group(function () {
    Route::get('/', AdminDashboard::class)->name('dashboard');
    Route::get('/manage-members', AdminMemberManagement::class)->name('manage-members');
    Route::get('/register-members', AdminRegisterMember::class)->name('register-members');
    Route::get('/manage-users', AdminUserManagement::class)->name('manage-users');
    Route::get('/manage-releases', AdminReleaseManagement::class)->name('manage-releases');
    Route::get('/manage-member-restrictions/{member}', AdminMemberRestrictionsManagement::class)->name('manage-member-restrictions');
    Route::get('/manage-clusters', AdminClusterManagement::class)->name('manage-clusters');
    Route::get('/transactions', AdminTransactionsHistory::class)->name('transactions');
    Route::get('/member-dividends/{member}', MemberDividends::class)->name('member-dividends');
});
