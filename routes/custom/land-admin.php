<?php

use App\Http\Livewire\LandAdmin\LandAdminDashboard;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:' . Role::LAND_ADMIN])->prefix('land-admin')->name('land-admin.')->group(function () {
    Route::get('/', LandAdminDashboard::class)->name('dashboard');
});
