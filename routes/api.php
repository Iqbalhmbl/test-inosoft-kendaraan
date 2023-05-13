<?php

use App\Http\Controllers\DashboardController;
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
Route::post('login', [App\Http\Controllers\Api\ApiController::class, 'login']);
Route::post('register', [App\Http\Controllers\Api\ApiController::class, 'register']);

Route::get('/dashboard', [\App\Http\Controllers\KendaraanController::class, 'dashboard']);

Route::get('index-mobil', [App\Http\Controllers\KendaraanController::class, 'indexMobil']);
Route::post('store-mobil', [App\Http\Controllers\KendaraanController::class, 'storeMobil']);
Route::get('show-mobil/{id}', [App\Http\Controllers\KendaraanController::class, 'showMobil']);
Route::get('edit-mobil/{id}', [App\Http\Controllers\KendaraanController::class, 'editMobil']);
Route::put('update-mobil/{id}', [App\Http\Controllers\KendaraanController::class, 'updateMobil']);

Route::get('index-motor', [App\Http\Controllers\KendaraanController::class, 'indexMotor']);
Route::post('store-motor', [App\Http\Controllers\KendaraanController::class, 'storeMotor']);
Route::get('show-motor/{id}', [App\Http\Controllers\KendaraanController::class, 'showMotor']);
Route::get('edit-motor/{id}', [App\Http\Controllers\KendaraanController::class, 'editMotor']);
Route::put('update-motor/{id}', [App\Http\Controllers\KendaraanController::class, 'updateMotor']);


//Route::middleware('auth:sanctum')->group(function () {
//
//});