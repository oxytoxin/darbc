<?php

use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\AdminUserManagement;
use App\Http\Livewire\Admin\AdminReleaseManagement;

Route::middleware(['auth', 'role:' . Role::ADMIN])->prefix('admin')->name('admin.')->group(function () {

    
    
});
