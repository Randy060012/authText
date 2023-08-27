<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login',[AuthController::class,'login'])->name("loginText");
Route::get('/register',[AuthController::class,'register'])->name("register");
Route::post('/textRg',[AuthController::class,'textRegister'])->name("enregistrement");
Route::post('/textLg',[AuthController::class,'textLogin'])->name("confirmation");
Route::get('/Logout',[AuthController::class,'logout'])->name("logout");


Route::middleware('auth:web', 'verified', 'cacheControl')->group(function () {
    Route::get('/', function () {return view('welcome');})->name("index");
});

