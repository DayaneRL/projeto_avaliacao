<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{LoginController,RegisterController};
use App\Http\Controllers\Dashboard\DashboardController;



Route::get('/', [LoginController::class , 'create'])->name('auth.login.create');
Route::post('/', [LoginController::class , 'store'])->name('auth.login.store');
Route::get('/cadastro_de_usuario', [RegisterController::class , 'create'])->name('auth.register.create');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
