<?php

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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

//Register User
Route::post('/register',[\App\Http\Controllers\AuthController::class,'register'])->name('registerPost');

//Halaman Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
