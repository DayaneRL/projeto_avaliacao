<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Question,Answer,Exam, ExamQuestion, QuestionsPrivate};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DownloadController extends Controller
{
    public function downloadExam(){
        $exam= request()->all();
        // $questions = Question::all(); ->codigo antigo
        $id = $exam['id'];

        $imageId = DB::select('SELECT user_header_id FROM exams where id = ?', [$id]);
        $imageId =  $imageId[0]->user_header_id;

        if($imageId == 0){
            $image = 'img/header/logocaraguasecretaria.jpeg';
        }else{
            $image = DB::select('SELECT logo FROM user_headers where id = ?', [$imageId]);
            $image =  $image[0]->logo;
        }

        $ExamQuestions =  Exam::find($exam['id'])->ExamQuestions;
        $questions =[];
        foreach($ExamQuestions as $ExamQuestion){
            if($ExamQuestion->private==1){
                $questionPrivate = QuestionsPrivate::where('exam_question_id','=',$ExamQuestion->id)->first() ;
                $questionPrivate['answers']= $ExamQuestion->AnswersPrivate;
                array_push($questions, $questionPrivate);
            }else{
                $question = $ExamQuestion->Question;
                $question['answers'] = $question->Answers;
                array_push($questions, $question);
            }
        }

        Pdf::setOption('isRemoteEnabled',true);
        $pdf = Pdf::loadView('exams/pdf/download/exam', compact('exam','questions','image'));
        return $pdf->download($exam['title'].'.pdf');
    }

    public function downloadAnswers(){
        $exam= request()->all();

        $id = $exam['id'];
        $questions = DB::select('SELECT questions.* FROM questions, exam_questions where exam_questions.exam_id = ? and exam_questions.question_id = questions.id', [$id]);

        $questions_ids= [];
        foreach($questions as $question){
            $questions_ids[]+=$question->id;
        }

        $replys = Answer::whereIn('question_id', $questions_ids)->where('valid',1)->get();

        $imageId = DB::select('SELECT user_header_id FROM exams where id = ?', [$id]);
        $imageId =  $imageId[0]->user_header_id;


        if($imageId == 0){
            $image = 'headers/logocaraguasecretaria.PNG';
        }else{
            $image = DB::select('SELECT logo FROM user_headers where id = ?', [$imageId]);
            $image =  $image[0]->logo;
        }

        Pdf::setOption('isRemoteEnabled',true);
        $pdf = Pdf::loadView('exams/pdf/download/answers', compact('exam','questions','replys','questions_ids','image'));
        return $pdf->download('gabarito:'.$exam['title'].'.pdf');
    }

    public function saveExam(){
        $examInfo= request()->all();
        if(isset($examInfo['testId'])){
            $exam = Exam::find($examInfo['testId']);
            $exam->updated_at = now();
        }else{
            $exam = new Exam;
            $exam->created_at = now();
        }

        $exam->title = $examInfo['title'];
        $exam->number_of_questions = $examInfo['number_of_questions'];
        $exam->category_id = $examInfo['category_id'];
        $exam->user_id = Auth::user()->id;
        $exam->date = now();
        $exam->created_at = now();
        $exam->updated_at = now();
        $exam->tags= 'teste';

        $exam->save();
        // after saving the id is saved here, return the id and pass it to js

        $exam->id;
        return $exam->id;
    }

    public function loadTest(){
        $exam= request()->all();

        $questions = $exam['questions'];
        $replys = array_column($questions, 'answers');

        $returnHTML = view('exams/pdf/preview/exam', compact('exam','questions','replys'))->render();

        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    public function loadAnswers(){
        $exam= request()->all();

        $questions = $exam['questions'];
        // $replys = array_column($questions, 'answers');

        $returnHTML = view('exams/pdf/preview/answers',compact('exam','questions'))->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }
}
