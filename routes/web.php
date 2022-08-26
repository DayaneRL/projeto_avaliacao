<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{LoginController,RegisterController};



Route::group([ 'middleware'=>'guest'], function(){
    Route::get('/', [LoginController::class , 'create'])->name('auth.login.create');
    Route::post('/', [LoginController::class , 'store'])->name('auth.login.store');

});


Route::group(['middleware'=>'auth'], function(){
    Route::get('/cadastro_de_usuario', [RegisterController::class , 'create'])->name('auth.register.create');
    Route::post('/cadastro_de_usuario', [RegisterController::class , 'store'])->name('auth.register.store');

    Route::get('/dashboard',function(){
        // return "dashboard";
        return view('dashboard');
    })->name('dashboard.index');

    Route::post('logout', [LoginController::class, 'destroy'])->name('auth.login.destroy');
});
