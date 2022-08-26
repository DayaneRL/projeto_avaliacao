<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class RegisterController extends Controller
{
    public function create(){
        return view('auth.create');
    }

    public function store(RegisterRequest $request){
        var_dump($request);
        return '0';
        $requestData = $request->validated();


        DB::beginTransaction();
        try{


            $user = User::create($requestData['user']);

            DB::commit();

            return redirect()
                ->route('auth.login.create')
                ->with('success', 'Conta criada com sucesso');
        }catch(Exception $exception){
            DB::rollBack();
        }
    }
}
