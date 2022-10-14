<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\{Auth, DB};
use App\Models\{Exam, Question, ExamAttribute, Reply, User};

class ExamService
{

    public static function storeExam(array $request): Exam
    {
        $tags = count($request['exam']['tags']) > 1 ?
                implode(', ', $request['exam']['tags']) :
                $request['exam']['tags'][0];
        $dt_exam = explode('/', $request['exam']['date']);

        $exam = Exam::create(
            array_merge(
                $request['exam'],
                [
                    'tags'=>$tags,
                    'date'=>new \DateTime("$dt_exam[2]-$dt_exam[1]-$dt_exam[0]"),
                    'user_id'=>Auth::user()->id
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
                 'date'=>new \DateTime("$dt_exam[2]-$dt_exam[1]-$dt_exam[0]"),
                ]
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

    public static function deadlines(User $user): array
    {
        $exams = Exam::where('user_id','=',Auth::user()->id)->get();
        $total = $exams->count();

        if($total==0){
            return [
                'yet_to_come'=>[0,0],
                'this_week'=>[0,0],
                'passed'=>[0,0]
            ];
        }

        $lastSundary = date('Y-m-d', strtotime("sunday -1 week"));
        $nexSunday   = date('Y-m-d', strtotime("sunday 0 week"));

        $exams_passed = $exams->where('date','<', date('Y-m-d'))->count();
        $exams_this_week = $exams->where('date','>', $lastSundary)->where('date','<',$nexSunday)->count();
        $exams_yet_to_come = $exams->where('date','>', $nexSunday)->count();

        return [
            'yet_to_come'=>[$exams_yet_to_come,round(self::descobrir_porcentagem($total, $exams_yet_to_come))],
            'this_week'=>[$exams_this_week,round(self::descobrir_porcentagem($total, $exams_this_week))],
            'passed'=>[$exams_passed,round(self::descobrir_porcentagem($total, $exams_passed))],
        ];
    }

    private static function descobrir_porcentagem(float $valor_base, float $valor): float
    {
         return $valor / $valor_base * 100;
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
