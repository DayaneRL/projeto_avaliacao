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
        $id = $exam['id'];


        $imageId = DB::select('SELECT user_header_id FROM exams where id = ?', [$id]);
        $imageId =  $imageId[0]->user_header_id;

        if($imageId == 0){
            $image = '/public/img/header/logocaraguasecretaria.jpeg';
            $schoolName = '';
        }else{
            $image = DB::select('SELECT logo, description FROM user_headers where id = ?', [$imageId]);
            $schoolName = $image[0]->description;
            $image =  '/public/storage/'.$image[0]->logo;
        }

        $examDate = Exam::find($exam['id'])->date;
        $examDate = explode('-', $examDate);

        $months = ['', 'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];

        $year = $examDate[0];
        $month = $months[intval($examDate[1])];
        $day = $examDate[2];
        $examDate = $day.' de '.$month.' de '.$year;

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
        $pdf = Pdf::loadView('exams/pdf/download/exam', compact('exam','questions','image', 'examDate', 'schoolName'));
        return $pdf->download($exam['title'].'.pdf');
    }

    public function downloadAnswers(){
        $exam= request()->all();

        $id = $exam['id'];

        $examDate = Exam::find($exam['id'])->date;
        $examDate = explode('-', $examDate);

        $months = ['', 'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];

        $year = $examDate[0];
        $month = $months[intval($examDate[1])];
        $day = $examDate[2];
        $examDate = $day.' de '.$month.' de '.$year;

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

        $imageId = DB::select('SELECT user_header_id FROM exams where id = ?', [$id]);
        $imageId =  $imageId[0]->user_header_id;


        if($imageId == 0){
            $image = '/public/img/header/logocaraguasecretaria.jpeg';
            $schoolName = '';
        }else{
            $image = DB::select('SELECT logo, description FROM user_headers where id = ?', [$imageId]);
            $schoolName = $image[0]->description;
            $image = '/public/storage/'. $image[0]->logo;
        }

        Pdf::setOption('isRemoteEnabled',true);
        $pdf = Pdf::loadView('exams/pdf/download/answers', compact('exam','questions','image', 'examDate', 'schoolName'));
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
