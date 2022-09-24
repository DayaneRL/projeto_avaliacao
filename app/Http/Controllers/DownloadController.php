<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Question,Reply};
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

        $replys = Reply::whereIn('question_id', $questions_ids)->get();

        Pdf::setOption('isRemoteEnabled',true);
        $pdf = Pdf::loadView('exams/pdf/answers', compact('request','questions','replys','questions_ids'));
        return $pdf->download('gabarito:'.$request['name'].'.pdf');
    }
}
