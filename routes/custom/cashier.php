<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('cashier')->name('cashier.')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('dashboard');
});
