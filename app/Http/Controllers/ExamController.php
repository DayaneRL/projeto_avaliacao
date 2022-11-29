<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\{Exam, Question, Category, Level, Tag, Answer, ExamQuestion, QuestionsPrivate};
use App\Http\Requests\ExamRequest;
use App\Services\ExamService;
use Barryvdh\DomPDF\Facade\Pdf;
use Hamcrest\Arrays\IsArray;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{

    public function index():View
    {
        $exams = Exam::where('user_id','=',Auth::user()->id)->get();
        return view('exams.index', compact('exams'));
    }

    public function indexFilter(Request $request):View
    {
        $lastSundary = date('Y-m-d', strtotime("sunday -1 week"));
        $nexSunday   = date('Y-m-d', strtotime("sunday 0 week"));
        if($request["filters"] == 'passed'){
            $exams = Exam::where('date','<', date('Y-m-d'))->where('user_id','=',Auth::user()->id)->get();
        }else if($request["filters"] == 'this_week'){
            $exams = Exam::where('date','>', $lastSundary)->where('date','<',$nexSunday)->where('user_id','=',Auth::user()->id)->get();
        }else if($request["filters"] == 'yet_to_come'){
            $exams = Exam::where('date','>', $nexSunday)->where('user_id','=',Auth::user()->id)->get();
        }
        return view('exams.index', compact('exams'));
    }

    public function create()
    {
        //View
        $categories = Category::all();
        $levels = Level::all();
        $tags = Tag::all();
        return view('exams.create', compact('categories', 'levels','tags'));
    }

    public function store(ExamRequest $request)
    {
        try{
            $request->validated();

            DB::beginTransaction();
            $exam = ExamService::storeExam(
                $request
            );

            DB::commit();
            return redirect()->route('exams.index')->with('success', "Prova cadastrado com sucesso" );

        }catch (\Throwable $e) {
            return $e->getMessage();
            DB::rollBack();
            return back()->withInput($request->input())->with('warning', "Algo deu errado" );
        }
    }

    public function preview(ExamRequest $request)
    {
        $request->validated();
        $request->all();
        // return $request->name;
        $exam=$request['exam'];
        $questions = Question::all();
        $questions_ids= [];

        // return var_dump($exam);

        foreach($questions as $question){
            $questions_ids[]+=$question['id'];
        }
        $replys = Answer::whereIn('question_id', $questions_ids)->get();

        return view('exams.store', compact('exam', 'questions','replys', 'questions_ids'));

    }


    public function show($id)
    {
        $exam = Exam::find($id);
        return view('exams.show', compact('exam'));
    }


    public function edit($id)
    {
        $exam = Exam::find($id);
        $categories = Category::all();
        $levels = Level::all();
        $tags = Tag::all();
        $exam_questions = ExamQuestion::where('exam_id','=',$exam->id)
                ->with('Question','Question.Answers')->get();

        $questions_private = QuestionsPrivate::where('exam_question_id','=',$exam->id)->get();

        return view('exams.create', compact('categories', 'levels', 'exam', 'tags','exam_questions','questions_private'));
    }


    public function update(ExamRequest $request, $id): RedirectResponse
    {
        try{
            DB::beginTransaction();

            $exam = Exam::findOrFail($id);
            ExamService::updateExam(
                $request->validated(),
                $exam
            );

            DB::commit();
            return redirect()->route('exams.index')->with('success', "Prova atualizada com sucesso" );

        }catch (\Throwable $e) {
            return $e->getMessage();
            DB::rollBack();
            return back()->withInput($request->input())->with('warning', "Algo deu errado" );;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $exam = Exam::findOrFail($id);
            ExamService::deleteExam($exam);
            DB::commit();
            return response()->json([
                'msg'  => 'Prova excluída com sucesso!'
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'msg'  => 'Não foi possível excluir a prova.'
            ], 500);
        }
    }

    public function find($id){
        try{
            $exam = Exam::findOrFail($id);

            return response()->json([
                'exam'      => $exam,
                'category'  => $exam->Category,
                'exam_date' => $exam->exam_date,
                'levels'    => $exam->levels,
                'tags_list' => $exam->tags_list
            ], 200);
        }catch (\Exception $ex) {
            return response()->json([
                $ex->getMessage()
            ], 500);
        }
    }
}
