<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Question,Answer,Exam};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller
{
    public function downloadExam(){
        $exam= request()->all();

        $questions = Question::all();
        $questions_ids= [];

        foreach($questions as $question){
            $questions_ids[]+=$question['id'];
        }

        $replys = Answer::whereIn('question_id', $questions_ids)->get();

        Pdf::setOption('isRemoteEnabled',true);
        $pdf = Pdf::loadView('exams/pdf/download/exam', compact('exam','questions','replys'));
        return $pdf->download($exam['title'].'.pdf');
    }
    public function downloadAnswers(){
        $exam= request()->all();

        $questions = Question::all();
        $questions_ids= [];

        foreach($questions as $question){
            $questions_ids[]+=$question['id'];
        }

        $replys = Answer::whereIn('question_id', $questions_ids)->where('valid',1)->get();

        Pdf::setOption('isRemoteEnabled',true);
        $pdf = Pdf::loadView('exams/pdf/download/answers', compact('exam','questions','replys','questions_ids'));
        return $pdf->download('gabarito:'.$exam['title'].'.pdf');
    }
    public function saveExam(){
        // a dayane já fez essa parte no ExamController store, vou tentar chamar o dela
        // mas esse estava funcionando também
        $examInfo= request()->all();
        if(isset($examInfo['testId'])){
            $exam = Exam::find($request->testId);
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

        $questions = Question::all();
        $questions_ids= [];

        foreach($questions as $question){
            $questions_ids[]+=$question['id'];
        }

        $replys = Answer::whereIn('question_id', $questions_ids)->get();

        $returnHTML = view('exams/pdf/preview/exam', compact('exam','questions','replys'))->render();

        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }
    public function loadAnswers(){
        //i am not saving the exam questions rn, the answers are kinda broken
        $exam= request()->all();

        $questions = Question::all();
        $questions_ids= [];

        foreach($questions as $question){
            $questions_ids[]+=$question['id'];
        }

        $replys = Answer::whereIn('question_id', $questions_ids)->where('valid',1)->get();

        $returnHTML = view('exams/pdf/preview/answers',compact('exam','questions','replys','questions_ids'))->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }
}
