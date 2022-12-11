<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;


class RegisterController extends Controller
{
    public function create(){
        return view('auth.create');
    }

    public function store(RegisterRequest $request){
        $requestData=$request->all();

        DB::beginTransaction();
        try{
            $user = User::create($requestData);

            DB::commit();

            return redirect()
                ->route('dashboard.index')
                ->with('success', 'Conta criada com sucesso');
        }catch(\Exception $exception){
            DB::rollBack();
        }
    }

    public function messages(){
        return [
            'required' => 'O campo :attribute deve ser preenchido'
        ];
    }
}
