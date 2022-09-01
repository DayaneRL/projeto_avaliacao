<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }

    public function attributes()
    {
        return [
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
