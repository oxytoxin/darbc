<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Controllers\ReportsDownloadController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Shared\ClusterlessMembers;
use App\Http\Livewire\Shared\ClusterMembers;
use App\Http\Livewire\Shared\MemberInformationQuery;
use App\Http\Livewire\TestComponent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MiscellaneousController::class, 'redirect'])->middleware('auth')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)
        ->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', LogoutController::class)->name('logout');
    Route::prefix('download-report')->name('download-report.')->group(function () {
        Route::get('/released/{release}/status/{status}', [ReportsDownloadController::class, 'releasesByStatus'])->name('releases-by-status');
        Route::get('/voided-releases/{release}', [ReportsDownloadController::class, 'voidedReleases'])->name('voided-releases');
        Route::get('/releases-by-cashier/{cashier}', [ReportsDownloadController::class, 'releasesByCashier'])->name('releases-by-cashier');
        Route::get('/voided-releases-by-cashier/{cashier}', [ReportsDownloadController::class, 'voidedReleasesByCashier'])->name('voided-releases-by-cashier');
        Route::get('/claimed-releases-by-type/{release}', [ReportsDownloadController::class, 'claimedReleasesByType'])->name('claimed-releases-by-type');
        Route::get('/members', [ReportsDownloadController::class, 'members'])->name('members');
        Route::get('/active-members', [ReportsDownloadController::class, 'active_members'])->name('active-members');
    });
});

Route::middleware(['auth', 'role:shared'])->group(function () {
    Route::get('member-information-query', MemberInformationQuery::class)->name('member-information-query');
    Route::get('cluster/{cluster}/members', ClusterMembers::class)->name('cluster-members');
    Route::get('clusterless-members', ClusterlessMembers::class)->name('clusterless-members');
});


Route::get('test', TestComponent::class);
