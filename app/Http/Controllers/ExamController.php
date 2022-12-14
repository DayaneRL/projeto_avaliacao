<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\{Exam, Question, Category, Level, Tag, Answer, ExamQuestion, QuestionsPrivate, UserHeader};
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

    public function create():View
    {
        $categories = Category::whereHas('Question')->get();
        $levels = Level::all();
        $tags = Tag::all();
        $headers = UserHeader::all();
        session()->forget('testSaved');
        return view('exams.create', compact('categories', 'levels','tags', 'headers'));
    }

    public function createQuestion(){
        echo "Consigo pegar a id: ".Auth::user()->id;
        return 'chamou a funcao';
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
            session(['testSaved' => $exam->id]);
            return $exam->id;
            // return redirect()->route('exams.index')->with('success', "Prova cadastrado com sucesso" );

        }catch (\Throwable $e) {
            return $e->getMessage();
            DB::rollBack();
            return back()->withInput($request->input())->with('warning', "Algo deu errado" );
        }
    }

    public function preview(ExamRequest $request)
    {
        // return $request;

        $request->validated();
        $request->all();

        $exam=$request['exam'];

        $exam_attributes = $request['exam_attributes'];

        $questions = [];
        if(isset($request['exam_attributes'])){
            foreach($request['exam_attributes'] as $attribute){
                if(isset($request['exam']['tags'])){
                    $question = Question::where('level_id','=',$attribute["level_id"])
                    ->where('category_id','=',$request['exam']['category_id'])
                    ->whereHas('QuestionTag', function($q) use ($request){
                        $q->whereIn('tag_id', $request['exam']['tags']);
                    })
                    ->with('Answers')
                    ->take($attribute["number_of_questions"])->get()->toArray();
                }else{
                    $question = Question::where('level_id','=',$attribute["level_id"])
                    ->where('category_id','=',$request['exam']['category_id'])
                    ->with('Answers')
                    ->take($attribute["number_of_questions"])->get()->toArray();
                }

                $questions = (count($questions)==0) ? $question : array_merge($questions, $question);
            }
        }

        if(isset($request['private_questions'])){
            foreach($request['private_questions'] as $key => $question){
                $index = count($questions);
                $questions[$index]['id']=QuestionsPrivate::count()+1;
                $questions[$index]['description'] = $question['description'];
                $questions[$index]['image'] = "0";
                $questions[$index]['answers'] = $question['answer'];
            }
        }
        $private_questions = $request['private_questions'];

        $questions_ids = array_column($questions, 'id');
        return view('exams.preview', compact('exam', 'questions', 'questions_ids', 'exam_attributes' , 'private_questions'));

    }


    public function show($id)
    {
        $exam = Exam::find($id);
        if($exam->user_id==Auth::user()->id){
            $questions_private = ExamQuestion::where('exam_id','=',$exam->id)->where('private','=','1')->with('QuestionsPrivate')->get();
            return view('exams.show', compact('exam','questions_private'));
        }else{
            return redirect()->route('exams.index')->with('warning', "Voc?? n??o tem permiss??o para acessar essa tela." );
        }
    }


    public function edit($id)
    {
        $exam = Exam::find($id);
        if($exam->user_id==Auth::user()->id){
            $categories = Category::all();
            $levels = Level::all();
            $tags = Tag::all();
            $exam_questions = ExamQuestion::where('exam_id','=',$exam->id)
                ->where('private','=','0')
                    ->with('Question','Question.Answers')->get();

            $questions_private = ExamQuestion::where('exam_id','=',$exam->id)
                ->where('private','=','1')
                ->with('QuestionsPrivate','AnswersPrivate')->get();

            $headers = UserHeader::all();
            return view('exams.create', compact('categories', 'levels', 'exam', 'tags','exam_questions','questions_private','headers'));

        }else{
            return redirect()->route('exams.index')->with('warning', "Voc?? n??o tem permiss??o para acessar essa tela." );
        }
    }


    public function update(ExamRequest $request, $id)
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
            return back()->with('success', "Prova atualizada com sucesso" );

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
                'msg'  => 'Prova exclu??da com sucesso!'
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'msg'  => 'N??o foi poss??vel excluir a prova.'
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
                'tags_list' => $exam->tags_list
            ], 200);
        }catch (\Exception $ex) {
            return response()->json([
                $ex->getMessage()
            ], 500);
        }
    }
}
