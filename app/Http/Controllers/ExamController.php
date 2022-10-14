<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\{Exam, Question, Category, Level, Tag};
use App\Http\Requests\ExamRequest;
use App\Services\ExamService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{

    public function index():View
    {
        $exams = Exam::where('user_id','=',Auth::user()->id)->get();
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
            DB::beginTransaction();

            $exam = ExamService::storeExam(
                $request->validated()
            );

            DB::commit();
            return redirect()->route('exams.index')->with('success', "Prova cadastrado com sucesso" );

        }catch (\Throwable $e) {
            return $e->getMessage();
            DB::rollBack();
            return back()->withInput($request->input())->with('warning', "Algo deu errado" );;
        }
    }

    public function preview(ExamRequest $request)
    {
        $request->all();
        $questions = Question::all();
        $questions_ids= [];
        foreach($questions as $question){
            $questions_ids[]+=$question['id'];
        }


        // $replys = Reply::whereIn('question_id', $questions_ids)->get();

        return view('exams.store', compact('request', 'questions','replys', 'questions_ids'));

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
        $tagsExemple = ['primeira_guerra'=>'Primeira Guerra', 'guerra_fria'=>'Guerra Fria','baskara'=>'Baskara'];
        return view('exams.create', compact('categories', 'levels', 'exam', 'tagsExemple'));
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
                'levels'    => $exam->levels
            ], 200);
        }catch (\Exception $ex) {
            return response()->json([
                'data'  => 'Algo deu errado.'
            ], 500);
        }
    }
}
