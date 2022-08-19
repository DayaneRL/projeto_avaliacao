<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function store(LoginRequest $request){
        $credentials = [
            'email' => $request->email,
            'password'=> $request -> password
        ];

        // falta encriptar a senha pro auth funcionar
        if(Auth::attempt($credentials)){
            return redirect()->route('dashboard');
        }

        return redirect()
            ->route('auth.login.create')
            ->with('warning', $credentials)
            ->withInput();
    }
}

