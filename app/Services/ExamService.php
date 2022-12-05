<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\{Auth, DB, Storage};
use App\Models\{
    Exam,
    Question,
    ExamAttribute,
    Answer,
    User,
    ExamQuestion,
    QuestionsPrivate,
    AnswersPrivate
};
use App\Http\Requests\ExamRequest;

class ExamService
{

    public static function storeExam(ExamRequest $request): Exam
    {
        $tags = isset($request['exam']['tags']) ?
                (count($request['exam']['tags']) > 1 ?
                implode(', ', $request['exam']['tags']) : $request['exam']['tags'][0])
            : '';
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

        $number = 0;

        if(isset($request['private_questions'])){
            foreach($request['private_questions'] as $key => $question){

                $number+=1;
                $examQuestion = ExamQuestion::create([
                    'exam_id'=>$exam->id,
                    'number'=>$number,
                    'private'=>true
                ]);

                $questPrivate = QuestionsPrivate::create([
                    'description'=>$question["description"],
                    // 'image'=>$question['image'],
                    'user_id'=>Auth::user()->id,
                    'exam_question_id'=>$examQuestion->id
                ]);


                if(isset($question["answer"]) && !isset($question["answer"]['rows'])){
                    foreach($question["answer"] as $answer){
                        $ansPrivate = AnswersPrivate::create(
                            array_merge(
                                $answer,
                                [
                                    'exam_question_id'=>$examQuestion->id,
                                    'user_id'=>Auth::user()->id,
                                ]
                            )
                        );
                    }
                }
            }
        }

        if(isset($request['exam_attributes'])){
            foreach($request['exam_attributes'] as $attribute){
                ExamAttribute::create(
                    array_merge(
                        $attribute,
                        ['exam_id' => $exam->id]
                    )
                );


                if(isset($tags) && $tags !== ''){
                    $questions = Question::where('level_id','=',$attribute["level_id"])
                    ->where('category_id','=',$request['exam']['category_id'])
                    ->whereHas('QuestionTag', function($q) use ($request){
                        $q->whereIn('tag_id', $request['exam']['tags']);
                    })
                    ->take($attribute["number_of_questions"])->get();
                }else{
                    $questions = Question::where('level_id','=',$attribute["level_id"])
                    ->where('category_id','=',$request['exam']['category_id'])
                    ->take($attribute["number_of_questions"])->get();
                }

                foreach($questions as $question){
                    $number+=1;
                    $examQuestion = ExamQuestion::create([
                        'exam_id'=>$exam->id,
                        'number'=>$number,
                        'question_id'=>$question->id,
                        'private'=>false
                    ]);
                }
            }
        }

        return $exam;
    }

    public static function updateExam(array $request, Exam $exam)
    {
        //:Exam
        $tags = isset($request['exam']['tags']) ?
                (count($request['exam']['tags']) > 1 ?
                    implode(', ', $request['exam']['tags']) : $request['exam']['tags'][0])
            : '';
        $dt_exam = explode('/', $request['exam']['date']);
        // $exam->update(
        //     array_merge(
        //         $request['exam'],
        //         ['tags'=>$tags,
        //          'date'=>new \DateTime("$dt_exam[2]-$dt_exam[1]-$dt_exam[0]"),
        //         ]
        //     )
        // );

        // foreach($request['exam_attributes'] as $attribute){
        //     $examAttribute = ExamAttribute::find($attribute['id']);
        //     $examAttribute->update(
        //         $attribute
        //     );
        // }

        if(isset($request['private_questions'])){
            foreach($request['private_questions'] as $key => $question){
                if(isset($question['id'])){
                    $examQuestion = ExamQuestion::find($question['id']);
                    if($examQuestion->private==1){
                        echo "<br/>";
                        echo $question['id']." - editar pergunta privada";

                        echo $question['question_private_id']." - question_private_id";
                        $QuestionsPrivate = QuestionsPrivate::find($question['question_private_id']);
                        $QuestionsPrivate->update([
                            'description'=>$question["description"]
                        ]);
                        echo "<br/>";
                        print_r($QuestionsPrivate);
                        echo "<br/>";

                        if(isset($question["answer"]) && !isset($question["answer"]['rows'])){
                            foreach($question["answer"] as $answer){
                                echo $answer['answer_private_id']." - answer_private_id";
                        //         $ansPrivate = AnswersPrivate::create(
                        //             array_merge(
                        //                 $answer,
                        //                 [
                        //                     'exam_question_id'=>$examQuestion->id,
                        //                     'user_id'=>Auth::user()->id,
                        //                 ]
                        //             )
                        //         );
                            }
                        }
                    }else{
                        echo $question['id']." - trocar pergunta aleatoria para privada";
                    }
                }else{
                    echo "!!!Adicionado mais uma pergunta privada!!!";
                }
            }
        }

    }

    private static function storeImage($question, QuestionsPrivate $questionPriv = null): string
    {
        if(!is_null($questionPriv) && $questionPriv->image) {
            $filePath = $questionPriv->getRawOriginal('logo');
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        // if ( $question->hasFile('image') && $question->file('image') ) {
        if(isset($question["image"])){
            $info =new \SplFileInfo($question["image"]);
            $fileName = uniqid(date('HisYmd')) . ".{$info->getExtension()}";
            Storage::putFileAs(
                'storage/exams', $question["image"], $fileName
            );
            return 'exams/' . $fileName;
        }else{
            return null;
        }
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
