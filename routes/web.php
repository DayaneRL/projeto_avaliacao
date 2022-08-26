<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{LoginController,RegisterController};



Route::get('/', [LoginController::class , 'create'])->name('auth.login.create');
Route::post('/', [LoginController::class , 'store'])->name('auth.login.store');
Route::get('/cadastro_de_usuario', [RegisterController::class , 'create'])->name('auth.register.create');
Route::post('/cadastro_de_usuario', [RegisterController::class , 'store'])->name('auth.register.store');

Route::get('/dashboard',function(){
    return "Dashboard";
})->name('dashboard.index');
