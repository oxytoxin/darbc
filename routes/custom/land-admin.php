<?php

use App\Http\Livewire\LandAdmin\LandAdminDashboard;
use App\Http\Livewire\LandAdmin\LandInformation;
use App\Http\Livewire\LandAdmin\NewLandInformation;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:' . Role::LAND_ADMIN])->prefix('land-admin')->name('land-admin.')->group(function () {
    Route::get('/', LandAdminDashboard::class)->name('dashboard');
    Route::get('/add-land-owner', NewLandInformation::class)->name('land-owner');
    Route::get('/information/{id}', LandInformation::class)->name('land-information');
});
