<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'password' =>['required', 'min:8', 'confirmed'],
        ];
    }

    public function attributes()
    {
        return [
            'name'=>'nome',
            'email'=>'email',
            'password'=>'senha',
        ];
    }

    public function messages(){
        return [
            'required' => 'O campo ":attribute" deve ser preenchido'
        ];
    }
}
