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
        $rules = [
            'exam.title'=>'required|max:255',
            'exam.number_of_questions'=>'required',
            'exam.tags'=>'nullable',
            'exam.category_id'=>'required',
            'exam.date'=>'required',
            'exam.user_header_id'=>'nullable|sometimes',
        ];


        if ($this->filled('exam_attributes'))
        {
            foreach($this->input('exam_attributes') as $key => $val)
            {
                $rules["exam_attributes.{$key}.number_of_questions"] = ['required'];
                $rules["exam_attributes.{$key}.level_id"] = ['required'];
                if ($this->filled("exam_attributes.{$key}.id"))
                {
                    $rules["exam_attributes.{$key}.id"] = ['required'];
                }
            }
        }

        if ($this->filled('private_questions'))
        {
            foreach($this->input('private_questions') as $key => $val){

                $rules["private_questions.{$key}.id"] = ['nullable','sometimes'];
                $rules["private_questions.{$key}.question_private_id"] = ['nullable','sometimes'];
                $rules["private_questions.{$key}.description"] = ['required'];
                // $rules["private_questions.{$key}.image"] = ['nullable','sometimes'];
                if(isset($val["answer"]) && !isset($val["answer"]['rows'])){
                    foreach($val["answer"] as $key2 => $answer){
                        $rules["private_questions.{$key}.answer.{$key2}.answer_private_id"] = ['nullable','sometimes'];
                        $rules["private_questions.{$key}.answer.{$key2}.alternative"] = ['required'];
                        $rules["private_questions.{$key}.answer.{$key2}.description"] = ['required'];
                        $rules["private_questions.{$key}.answer.{$key2}.valid"] = ['required'];
                    }
                }

            }
        }

        if ($this->filled('private_questions'))
        {
            foreach($this->input('private_questions') as $key => $val){

                $rules["private_questions.{$key}.id"] = ['nullable','sometimes'];
                $rules["private_questions.{$key}.question_private_id"] = ['nullable','sometimes'];
                $rules["private_questions.{$key}.description"] = ['required'];
                // $rules["private_questions.{$key}.image"] = ['nullable','sometimes'];
                if(isset($val["answer"]) && !isset($val["answer"]['rows'])){
                    foreach($val["answer"] as $key2 => $answer){
                        $rules["private_questions.{$key}.answer.{$key2}.answer_id"] = ['nullable','sometimes'];
                        $rules["private_questions.{$key}.answer.{$key2}.answer_private_id"] = ['nullable','sometimes'];
                        $rules["private_questions.{$key}.answer.{$key2}.alternative"] = ['required'];
                        $rules["private_questions.{$key}.answer.{$key2}.description"] = ['required'];
                        $rules["private_questions.{$key}.answer.{$key2}.valid"] = ['required'];
                    }
                }

            }
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'exam.title.required'=>'O campo T??tulo ?? obrigat??rio.',
            'exam.title.max'=>'O campo T??tulo deve conter no m??ximo 255 caract??res.',
            'exam.number_of_questions.required'=>'O campo Total de quest??es ?? obrigat??rio.',
            'exam.tags.required'=>'O campo Tags ?? obrigat??rio.',
            'exam.category_id.required'=>'O campo Tags ?? obrigat??rio.',
            'exam.date.required'=>'O campo Data da Prova ?? obrigat??rio.',
        ];
        if ($this->filled('exam_attributes'))
        {
            foreach($this->input('exam_attributes') as $key => $val)
            {
                $messages["exam_attributes.{$key}.number_of_questions.required"] = 'O campo Qtd. de quest??es ?? obrigat??rio.';
                $messages["exam_attributes.{$key}.level_id.required"] = 'O campo N??vel ?? obrigat??rio.';
            }
        }
        if ($this->filled('private_questions'))
        {
            foreach($this->input('private_questions') as $key => $val){
                $messages["private_questions.{$key}.description.required"] = 'O campo Descri????o '.$key.' ?? obrigat??rio.';
                if(isset($val["answer"]) &&  !isset($val["answer"]['rows'])){
                    foreach($val["answer"] as $key2 => $answer){
                        $messages["private_questions.{$key}.answer.{$key2}.alternative.required"] = 'O campo Alternativa '.$key.' ?? obrigat??rio.';
                        $messages["private_questions.{$key}.answer.{$key2}.description.required"] = 'O campo Descri????o da resposta da quest??o '.$key.' ?? obrigat??rio.';
                        $messages["private_questions.{$key}.answer.{$key2}.valid.required"] = 'Selecionar a alternativa correta ?? obrigat??rio.';
                    }
                }
            }
        }
        return $messages;
    }
}
