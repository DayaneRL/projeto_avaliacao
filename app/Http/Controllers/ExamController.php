<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\{Exam, Question, Category, Level};
use App\Http\Requests\ExamRequest;
use App\Services\ExamService;

class ExamController extends Controller
{

    public function index():View
    {
        $exams = Exam::all();
        return view('exams.index', compact('exams'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $levels = Level::all();
        return view('exams.create', compact('categories', 'levels'));
    }

    public function store(ExamRequest $request): RedirectResponse
    {
        try{
            DB::beginTransaction();

            $exam = ExamService::storeExam(
                $request->validated()
            );

            DB::commit();
            return redirect()->route('exams.index')->with('success', "Prova cadastrado com sucesso" );

        }catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput($request->input())->with('warning', "Algo deu errado" );;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('exams.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
