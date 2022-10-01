<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category,Exam, QuestionsPrivate, UserHeader, User};
use App\Services\ExamService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        if(!Auth::user()->admin) {
            $examsCount = Exam::where('user_id','=',Auth::user()->id)->count();
            $questionsCount = QuestionsPrivate::where('user_id','=',Auth::user()->id)->count();
            $headersCount = UserHeader::where('user_id','=',Auth::user()->id)->count();

            $deadlines = ExamService::deadlines(Auth::user());

            return view('dashboard.index',
                    compact(
                        'categories',
                        'examsCount',
                        'questionsCount',
                        'headersCount',
                        'deadlines'
                    )
            );
        }
        else {
            $usersCount = User::all()->count();
            return view('dashboard.index',
                compact(
                    'categories',
                    'usersCount',
                )
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
