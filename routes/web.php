<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Verify;
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
});

Route::middleware(['auth', 'role:shared'])->group(function () {
    Route::get('member-information-query', MemberInformationQuery::class)->name('member-information-query');
    Route::get('cluster/{cluster}/members', ClusterMembers::class)->name('cluster-members');
    Route::get('clusterless-members', ClusterlessMembers::class)->name('clusterless-members');
});


Route::get('test', TestComponent::class);
