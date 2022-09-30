<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Question,Reply,Exam};
use Barryvdh\DomPDF\Facade\Pdf;

class DownloadController extends Controller
{
    public function downloadExam(){
        // trying to get the request with ajax
        $request= request()->all();

        $questions = Question::all();
        $questions_ids= [];

        foreach($questions as $question){
            $questions_ids[]+=$question['id'];
        }

        $replys = Reply::whereIn('question_id', $questions_ids)->get();

        Pdf::setOption('isRemoteEnabled',true);
        $pdf = Pdf::loadView('exams/pdf/test', compact('request','questions','replys'));
        return $pdf->download($request['name'].'.pdf');
    }
    public function downloadAnswers(){
        $request= request()->all();

        $questions = Question::all();
        $questions_ids= [];

        foreach($questions as $question){
            $questions_ids[]+=$question['id'];
        }

        $replys = Reply::whereIn('question_id', $questions_ids)->where('valid',1)->get();

        Pdf::setOption('isRemoteEnabled',true);
        $pdf = Pdf::loadView('exams/pdf/answers', compact('request','questions','replys','questions_ids'));
        return $pdf->download('gabarito:'.$request['name'].'.pdf');
    }
    public function saveExam(){
        $request= request()->all();
        var_dump($request);
        //here i have the name of the test and the questions ids. there's nothing about questions
        //edited yet
        //i need to get the test id after saving it, so i can pass it to the load and download functions


        if($request->testId){
            $exam = Exam::find($request->testId);
            $exam->updated_at = now();
        }else{
            $exam = new Exam;
            $exam->created_at = now();
        }

        $exam->title = $request->name;
        $exam->number_of_questions = $request->number_of_questions;
        $exam->date = $request->date;



        $post->save();
        // after saving the id is saved here, return the id and pass it to js
        $post->id;
        return true;
    }
    public function loadTest(){


        $returnHTML = view('exams/pdf/teste')->compact('request','questions','replys')->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }
    public function loadAnswers(){

    }
}
