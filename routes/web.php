<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Auth\CabinetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Backend\CategoryController;
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

//главная
Route::get('/', function () {
    return view('welcome');
    //return view('popup.popup',['status'=>'warning','message'=>'привет мир','redirect'=>route('enter')]);
})->name('main');


//авторизация
Route::get('/enter/{user:login?}', [LoginController::class,'enter'])->name('enter');
Route::post('/login', [LoginController::class,'login'])->name('login');
Route::get('/logout', [LoginController::class,'logout'])->name('logout')->middleware('auth');

//регистрация
//route implicit bind
Route::post('/register/{user:login?}', [RegisterController::class,'create'])->name('register');
Route::get('/confirm/{verifyuser}', [RegisterController::class,'store'])->name('confirm')->middleware('signed');

//восстановление пароля
Route::post('/recovery', [ResetPasswordController::class,'recovery'])->name('recovery');
Route::get('/reset/{user:login}', [ResetPasswordController::class,'reset'])->name('reset')->middleware('signed');

//Изменение регистрационных данных
Route::get('/cabinet', [CabinetController::class,'cabinet'])->name('cabinet')->middleware('auth');
Route::post('/cabinet', [CabinetController::class,'change'])->name('cabinet.change')->middleware('auth');
Route::get('/cabinet/{verifycabinet}/{email}', [CabinetController::class,'save'])->name('cabinet.save')->middleware('signed');

//админка
Route::group(['middleware' => ['admin'], 'prefix' => 'admin'], function () {
    Route::get('/', [AdminController::class,'index'])->name('admin');
    Route::resource('category', CategoryController::class);
  //  Route::resource('post', PostController::class);
});
