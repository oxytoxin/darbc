<?php

use App\Http\Controllers\Api\ApiMemberInformationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('member-information', ApiMemberInformationController::class)->only('index', 'show');
Route::get('member-darbc-ids', [ApiMemberInformationController::class, 'darbc_ids']);
Route::get('member-darbc-names', [ApiMemberInformationController::class, 'darbc_names']);
