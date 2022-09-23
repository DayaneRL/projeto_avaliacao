<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user_id = $this->user['id'] ?? null;

        $rules = [
            'user.name' => ['required', 'string'],
            'user.email' => ['email', 'unique:users,email,' . $user_id . ',id'],
            'user.admin' => ['required'],
        ];

        if ($this->method() === 'PUT')
        {
            if ($this->filled('user.password'))
            {
                $rules['user']['password'] = ['required', 'confirmed'];
                $rules['user']['confirm_password'] = ['required'];
            }
        }
        else if ($this->method() === 'POST')
        {
            $rules['user']['password'] = ['required', 'confirmed'];
            $rules['user']['confirm_password'] = ['required'];
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'user.name.required' => 'O campo Nome é obrigatório.',
            'user.name.string' => 'O campo Nome deve conter apenas letras.',
            'user.email.email' => 'O campo E-mail deve ser válido',
            'user.email.unique' => 'Este E-mail não está disponível.',
            'user.admin.required' => 'O campo Tipo é obrigatório.',
            'user.password.required' => 'A Senha é obrigatória.',
            'user.password.confirmed' => 'A Confirmação Senha não coincide.',
            'user.confirm_password.required' => 'A confirmação da senha é obrigatória.'
        ];

        return $messages;
    }
}
