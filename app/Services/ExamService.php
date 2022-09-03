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
        $exam->number_of_questions =$request['exam']['number_of_questions'];
        $exam->category_id = $request['exam_questions']['category_id'];
        $exam->save();

        $questions = new Question();
        $questions->number = 1;
        $questions->text = 'Quando aconteceu a primeira guerra';
        $questions->exam_id = $exam->id;
        $questions->save();

        for($i=0;$i<2;$i++){
            $attributes = new ExamAttribute();
            $attributes->number_of_questions = 5;
            $attributes->level_id = $request['exam_attributes']['level_id'];
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
