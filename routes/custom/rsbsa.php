<?php

use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Rsbsa\EditRsbsa;
use App\Http\Livewire\Rsbsa\ViewRsbsa;
use App\Http\Livewire\Rsbsa\CreateRsbsa;
use App\Http\Livewire\Rsbsa\RsbsaDashboard;
use App\Http\Livewire\Admin\AdminUserManagement;
use App\Http\Livewire\Rsbsa\RsbsaMemberManagement;
use App\Http\Livewire\Admin\AdminReleaseManagement;

Route::middleware(['auth', 'role:' . Role::RELEASE_ADMIN])->prefix('rsbsa')->name('rsbsa.')->group(function () {

    Route::get('/', RsbsaDashboard::class)->name('dashboard');
    Route::get('/manage-members', RsbsaMemberManagement::class)->name('manage-members');
    Route::get('/register/{member}', CreateRsbsa::class)->name('register');
    Route::get('/rsbase/edit/{rsbsa}', EditRsbsa::class)->name('edit');   
    Route::get('/rsbsa/view/{rsbsa}', ViewRsbsa::class)->name('view');

    

    
});
