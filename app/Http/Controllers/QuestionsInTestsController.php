<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Question;
use App\QuestionsInTests;

class QuestionsInTestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $qt = QuestionsInTests::create($input);
        die(($qt)?"true":"false");
    }

    public function delete(Request $request)
    {
        $input = $request->all();
        $qt = QuestionsInTests::where([
            "question_id"=>$request->question_id,
            "test_id"=>$request->test_id
        ])->delete();
        die(($qt)?"true":"false");
    }

    public function json(Request $request)
    {
        $userId = \Auth::user()->id;
        if ($request->question_categorie_id!=0){
            $questions = Question::where([
                'categorie_id'=>$request->question_categorie_id,
                'soft_delete'=>0,
                'user_id' => $userId
            ])->get();
        } else {
            $questions = Question::where([
                'soft_delete'=>0,
                'user_id' => $userId
            ])->get();
        }
        foreach ($questions as $question){
            $qt = QuestionsInTests::where([
                'question_id'=>$question->id,
                'test_id'=> $request->test_id
            ])->first();
            $question->qt = ($qt!=null);
        }
        return view('questions.json', [
            'questions'=> $questions
            ]);
    }
}
