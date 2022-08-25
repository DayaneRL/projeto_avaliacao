<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;



// tela user logado
// tela adm logado

// todas pelo middleware login

Route::get('/', [LoginController::class , 'create'])->name('auth.login.create');
Route::post('/', [LoginController::class , 'store'])->name('auth.login.store');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
