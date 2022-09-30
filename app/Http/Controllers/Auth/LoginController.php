<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\UserService;

class LoginController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function store(LoginRequest $request){
        $credentials = [
            'email' => $request->email,
            'password'=> $request->password
        ];

        if(Auth::attempt($credentials)){
            return redirect()->route('dashboard.index');
            // $userRole = auth()->user()->role;
            // return redirect(UserService::getDashboardRouteBasedOnUserRole($userRole));
        }

        return redirect()
            ->route('auth.login.create')
            ->with('warning', 'Usuário ou senha incorretos!')
            ->withInput();
    }

    public function destroy(){
        Auth::logout();
        return redirect()->route('auth.login.create');
    }
}

