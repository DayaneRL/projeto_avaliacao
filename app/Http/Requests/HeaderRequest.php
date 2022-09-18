<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeaderRequest extends FormRequest
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
        return [
            'header.description'=>'required|max:255',
            'header.logo'       =>'required',
        ];
    }

    public function messages()
    {
        $messages = [
            'header.description.required'=>'O campo Descrição é obrigatório.',
            'header.description.max'=>'O campo Descrição deve conter no máximo 255 caractéres.',
            'header.logo.required'=>'O campo Imagem é obrigatório.',
        ];
        return $messages;
    }
}
