<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\{Auth, DB};
use App\Models\{Exam, Question, ExamAttribute};

class ExamService
{

    public static function storeExam(array $request): Exam
    {
        $exam = new Exam();
        $exam->title = $request['exam']['title'];
        $exam->tags = implode(', ', $request['exam']['tags']);
        $exam->number_of_questions = $request['exam']['number_of_questions'];
        $exam->category_id = $request['exam']['category_id'];

        $dt_exam = explode('/', $request['exam']['date']);
        $exam->date = new \DateTime("$dt_exam[2]-$dt_exam[1]-$dt_exam[0]");

        $exam->save();

        for($i=0; $i<$request['exam']['number_of_questions']; $i++){
            $questions = new Question();
            $questions->number = $i;
            $questions->text = 'Descrição da pergunta '.$i;
            $questions->exam_id = $exam->id;
            $questions->save();
        }

        foreach($request['exam_attributes'] as $attribute){
            $attributes = new ExamAttribute();
            $attributes->number_of_questions = $attribute['number_of_questions'];
            $attributes->level_id = $attribute['level_id'];
            $attributes->exam_id = $exam->id;
            $attributes->save();
        }

        return $exam;
    }

    public static function updateExam(array $request, Exam $exam): Exam
    {
        $exam = Exam::find($exam->id);
        $exam->title = $request['exam']['title'];
        $exam->tags = implode(', ', $request['exam']['tags']);
        $exam->number_of_questions = $request['exam']['number_of_questions'];
        $exam->category_id = $request['exam_questions']['category_id'];
        $exam->update();
        return $exam;
    }
}
