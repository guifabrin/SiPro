<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionCategory;
use App\QuestionsInTests;
use App\Test;
use App\Http\Controllers\Base\Controller;

class QuestionsInTestsController extends Controller
{
    public function index(Test $test, QuestionCategory $questionCategory)
    {
        $questionCategories = \Auth::user()->questionCategories()->notRemoved()->withoutFather()->get();
        $nonRemoved = \Auth::user()->questions()->notRemoved();
        $questions = (isset($questionCategory)? $nonRemoved->fromCategory($questionCategory) :
            $nonRemoved->withoutCategory())->get();
        return view("question_in_test.form", [
            "test" => $test,
            "questionCategory" => $questionCategory,
            "questionCategories" => $questionCategories,
            "questions" => $questions
        ]);
    }


    public function store(Test $test, Question $question)
    {
        $stored = QuestionsInTests::create([
            "question_id" => $question->id,
            "test_id" => $test->id
        ]);
        return response("", $stored ? 200 : 500);
    }

    public function destroy(Test $test, Question $question)
    {
        $questionInTest = QuestionsInTests::where([
            "question_id" => $question->id,
            "test_id" => $test->id
        ]);
        $deleted = $questionInTest->delete();
        return response("", $deleted ? 200 : 500);
    }
}
