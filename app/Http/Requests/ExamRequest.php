<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
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
            'exam.title'=>'required|max:255',
            'exam.number_of_questions'=>'required',
            'exam.tags'=>'required',
            'exam.category_id'=>'required',
            'exam.date'=>'required',
            'exam_attributes.0.number_of_questions'=>'required',
            'exam_attributes.0.level_id'=>'required',
        ];
    }

    public function messages()
    {
        $messages = [
            'exam.title.required'=>'O campo Título é obrigatório.',
            'exam.title.max'=>'O campo Título deve conter no máximo 255 caractéres.',
            'exam.number_of_questions.required'=>'O campo Total de questões é obrigatório.',
            'exam.tags.required'=>'O campo Tags é obrigatório.',
            'exam.category_id.required'=>'O campo Tags é obrigatório.',
            'exam.date.required'=>'O campo Data da Prova é obrigatório.',
            'exam_attributes.0.number_of_questions.required'=>'O campo Qtd. de questões é obrigatório.',
            'exam_attributes.0.level_id.required'=>'O campo Nível é obrigatório.',
        ];
        return $messages;
    }
}
