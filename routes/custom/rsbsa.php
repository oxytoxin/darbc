<?php

use App\Http\Livewire\Rsbsa\RsbsaDashboard;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\AdminUserManagement;
use App\Http\Livewire\Admin\AdminReleaseManagement;
use App\Http\Livewire\Rsbsa\RsbsaMemberManagement;

Route::middleware(['auth', 'role:' . Role::RELEASE_ADMIN])->prefix('rbsa')->name('rbsa.')->group(function () {

    Route::get('/', RsbsaDashboard::class)->name('dashboard');
    Route::get('/manage-members', RsbsaMemberManagement::class)->name('manage-members');
    
});
