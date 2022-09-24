<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\DownloadController;
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

    Route::post('/download_exam', [DownloadController::class , 'downloadExam'])->name('download.exam');

    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/exams', ExamController::class);
    Route::resource('/headers', HeaderController::class);


    Route::post('logout', [LoginController::class, 'destroy'])->name('auth.login.destroy');
});
