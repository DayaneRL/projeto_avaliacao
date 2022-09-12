<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\{Auth, DB};
use App\Models\{Exam, Question, ExamAttribute, Reply};

class ExamService
{

    public static function storeExam(array $request): Exam
    {
        $tags = count($request['exam']['tags']) > 1 ? implode(', ', $request['exam']['tags']) : $request['exam']['tags'][0];
        $dt_exam = explode('/', $request['exam']['date']);

        $exam = Exam::create(
            array_merge(
                $request['exam'],
                [
                    'tags'=>$tags,
                    'date'=>new \DateTime("$dt_exam[2]-$dt_exam[1]-$dt_exam[0]")
                ]
            )
        );

        foreach($request['exam_attributes'] as $attribute){
            ExamAttribute::create(
                array_merge(
                    $attribute,
                    ['exam_id' => $exam->id]
                )
            );
        }

        // for($i=0; $i<$request['exam']['number_of_questions']; $i++){
        //     $question = new Question();
        //     $question->number = ($i+1);
        //     $question->text = 'Descrição da pergunta '.($i+1);
        //     $question->exam_id = $exam->id;
        //     $question->save();

            // $reply = new Reply();
            // $reply->question_id = $question->id;
            // $question->text = 'Resposta da questão '
            // $reply->alternative = 'a';
            // $reply->valid = 'a';
            // $reply->exam_id = $exam->id;
            // $reply->save();
        // }

        return $exam;
    }

    public static function updateExam(array $request, Exam $exam): Exam
    {
        $tags = count($request['exam']['tags']) > 1 ? implode(', ', $request['exam']['tags']) : $request['exam']['tags'][0];
        $dt_exam = explode('/', $request['exam']['date']);
        $exam->update(
            array_merge(
                $request['exam'],
                ['tags'=>$tags,
                 'date'=>new \DateTime("$dt_exam[2]-$dt_exam[1]-$dt_exam[0]")]
            )
        );

        foreach($request['exam_attributes'] as $attribute){
            $examAttribute = ExamAttribute::find($attribute['id']);
            $examAttribute->update(
                $attribute
            );
        }

        return $exam;
    }

    public static function deleteExam(Exam $exam): void
    {
        $exam->delete();
    }

    public static function forceDeleteExam(Exam $exam): void
    {
        $exam->forceDelete();
    }

    public static function restoreExam(Exam $exam): void
    {
        $exam->restore();
    }
}
