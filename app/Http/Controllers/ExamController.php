<?php

namespace App\Http\Controllers;

use App\Models\{Category,Level,Question,Reply};
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('exams.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $levels = Level::all();

        return view('exams.create', compact('categories', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->all();
        $questions = Question::all();
        $questions_ids= [];
        foreach($questions as $question){
            $questions_ids[]+=$question['id'];
        }
        $replys = Reply::whereIn('question_id', $questions_ids)->get();

        return view('exams.store', compact('request', 'questions','replys'));

        // return view('exams.pdf.test', compact('request','questions','replys'));

    }
    public function downloadExam(){
        // bring the $request to here
        $questions = Question::all();
        $questions_ids= [];
        foreach($questions as $question){
            $questions_ids[]+=$question['id'];
        }
        $replys = Reply::whereIn('question_id', $questions_ids)->get();

        Pdf::setOption('isRemoteEnabled',true);
        $pdf = Pdf::loadView('exams/pdf/test', compact('request','questions','replys'));
        return $pdf->download('prova.pdf');
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
