<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;
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
    dd(User::find(100)->login);
    return view('welcome');
    //return view('popup.popup',['status'=>'warning','message'=>'привет мир','redirect'=>route('enter')]);
})->name('main');



Route::get('/enter/{user:login?}', [LoginController::class,'enter'])->name('enter');
Route::post('/login', [LoginController::class,'login'])->name('login');
Route::get('/logout', [LoginController::class,'logout'])->middleware('auth');

//route implicit bind
Route::post('/register/{user:login?}', [RegisterController::class,'create'])->name('register');
Route::get('/confirm/{verifyuser}', [RegisterController::class,'store'])->name('confirm')->middleware('signed');
