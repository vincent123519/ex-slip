<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcuseSlipController;


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

Route::post('/excuse_slips/store', [ExcuseSlipController::class, 'store'])->name('excuse_slips.store');
Route::get('/excuse_slips/list', [ExcuseSlipController::class, 'studentExcuseSlipList'])->name('excuse_slips.index');

