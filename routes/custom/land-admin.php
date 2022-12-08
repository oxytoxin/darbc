<?php

use App\Http\Livewire\LandAdmin\LandAdminDashboard;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('land-admin')->name('land-admin.')->group(function () {
    Route::get('/', LandAdminDashboard::class)->name('dashboard');
});
