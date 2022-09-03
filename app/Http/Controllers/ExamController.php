<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Level;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    function getQuestionsTest(){
        $data = array(
            "Nostrud fugiat dolor anim pariatur labore. R:1" =>
            array("Officia culpa nostrud commodo ex occaecat sit irure cupidatat ex consectetur ipsum ipsum. ",
            "Laborum quis quis ullamco tempor laborum pariatur ullamco ex exercitation dolor tempor anim.",
            "Adipisicing anim sunt laborum nulla sunt adipisicing ullamco mollit minim.",
            "Aliquip veniam cillum officia nisi voluptate id aute."),

            "Nostrud fugiat dolor anim pariatur labore. R:2" =>

            array("Officia culpa nostrud commodo ex occaecat sit irure cupidatat ex consectetur ipsum ipsum. ",
            "Laborum quis quis ullamco tempor laborum pariatur ullamco ex exercitation dolor tempor anim.",
            "Adipisicing anim sunt laborum nulla sunt adipisicing ullamco mollit minim.",
            "Aliquip veniam cillum officia nisi voluptate id aute."),

            "Nostrud fugiat dolor anim pariatur labore. R:3" =>

            array("Officia culpa nostrud commodo ex occaecat sit irure cupidatat ex consectetur ipsum ipsum. ",
            "Laborum quis quis ullamco tempor laborum pariatur ullamco ex exercitation dolor tempor anim.",
            "Adipisicing anim sunt laborum nulla sunt adipisicing ullamco mollit minim.",
            "Aliquip veniam cillum officia nisi voluptate id aute."),
        );
        return $data;
    }

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
        // gerar a prova
        $formData = $request->all();
        $fakeData = self::getQuestionsTest();
        return view('exams.store', compact('formData', 'fakeData'));
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
