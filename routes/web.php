<?php

use App\Http\Controllers\Auth\LoginController;
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
    return view('welcome');
})->name('main');

Route::get('/enter/{user:login?}', [LoginController::class,'enter']);
Route::post('/login', [LoginController::class,'login'])->name('login');
Route::get('/logout', [LoginController::class,'logout'])->middleware('auth');

//route implicit bind
Route::post('/register/{user:login?}', [LoginController::class,'create'])->name('register');
Route::get('/confirm/{verifyUser}', [LoginController::class,'create'])->name('confirm')->middleware('signed');
