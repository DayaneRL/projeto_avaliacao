<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\Auth\{LoginController,RegisterController};


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

Route::group([ 'middleware'=>'guest'], function(){
    Route::get('/', [LoginController::class , 'create'])->name('auth.login.create');
    Route::post('/', [LoginController::class , 'store'])->name('auth.login.store');

});

Route::group(['middleware'=>'auth'], function(){

    Route::get('/cadastro_de_usuario', [RegisterController::class , 'create'])->middleware('admin:true')->name('auth.register.create');
    Route::post('/cadastro_de_usuario', [RegisterController::class , 'store'])->middleware('admin:true')->name('auth.register.store');

    Route::resource('/exams', ExamController::class)->middleware('admin:false');
    Route::get('/findExam/{id}', [ExamController::class,'find'])->middleware('admin:false');
    Route::resource('/headers', HeaderController::class)->middleware('admin:false');
    Route::get('/findHeader/{id}', [HeaderController::class,'find'])->middleware('admin:false');
    Route::post('/updateLogo', [HeaderController::class,'updateLogo'])->middleware('admin:false');

    Route::resource('/dashboard', DashboardController::class);
    Route::post('logout', [LoginController::class, 'destroy'])->name('auth.login.destroy');

});
