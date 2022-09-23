<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    ExamController,
    HeaderController,
    UserController
};
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

    Route::resource('/dashboard', DashboardController::class);
    Route::post('logout', [LoginController::class, 'destroy'])->name('auth.login.destroy');

    Route::post('/profile', [UserController::class,'show'])->name('profile');

    Route::group(['middleware' => 'admin:false'], function() {
        Route::resource('/exams', ExamController::class);
        Route::get('/findExam/{id}', [ExamController::class,'find']);
        Route::resource('/headers', HeaderController::class);
        Route::get('/findHeader/{id}', [HeaderController::class,'find']);
        Route::post('/updateLogo', [HeaderController::class,'updateLogo']);
    });

    Route::group(['middleware' => 'admin:true'], function() {
        Route::get('/cadastro_de_usuario', [RegisterController::class , 'create'])->name('auth.register.create');
        Route::post('/cadastro_de_usuario', [RegisterController::class , 'store'])->name('auth.register.store');

        Route::resource('/users', UserController::class);
    });
});
