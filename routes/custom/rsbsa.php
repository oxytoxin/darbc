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
use App\Http\Controllers\Rsbase\RsbsaPdfController;

Route::middleware(['auth', 'role:' . Role::RSBSA_OFFICER,])->prefix('rsbsa')->name('rsbsa.')->group(function () {

    Route::get('/', RsbsaDashboard::class)->name('dashboard');
    Route::get('/manage-members', RsbsaMemberManagement::class)->name('manage-members');
    Route::get('/register/{member}', CreateRsbsa::class)->name('register');
    Route::get('/rsbsa/edit/{rsbsa}', EditRsbsa::class)->name('edit');
    Route::get('/rsbsa/view/{rsbsa}', ViewRsbsa::class)->name('view');

    // RSBSA official-form PDF: inline preview, download, and the layout tuner
    Route::get('/pdf/{rsbsa}', [RsbsaPdfController::class, 'inline'])->name('pdf');
    Route::get('/pdf-download/{rsbsa}', [RsbsaPdfController::class, 'download'])->name('pdf.download');
    Route::get('/pdf-tuner/{rsbsa}', [RsbsaPdfController::class, 'tuner'])->name('pdf.tuner');
    Route::post('/pdf-tuner-save', [RsbsaPdfController::class, 'save'])->name('pdf.tuner.save');




});
