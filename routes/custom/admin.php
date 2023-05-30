<?php

use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\AdminUserManagement;
use App\Http\Livewire\Admin\AdminReleaseManagement;

Route::middleware(['auth', 'role:' . Role::ADMIN])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/manage-users', AdminUserManagement::class)->name('manage-users');
    Route::get('/manage-releases', AdminReleaseManagement::class)->name('manage-releases');
});
