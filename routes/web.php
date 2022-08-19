<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;


// tela user logado
// tela adm logado

// todas pelo middleware login

Route::get('/', [LoginController::class , 'create'])->name('auth.login.create');
Route::post('/', [LoginController::class , 'store'])->name('auth.login.store');

Route::get('/logado',function(){
    return view('dashboard');
});
