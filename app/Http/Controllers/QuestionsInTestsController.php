<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionCategory;
use App\QuestionsInTests;
use App\Test;

class QuestionsInTestsController extends ApplicationController
{
    /**
     * @param Test $test
     * @param QuestionCategory $questionCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Test $test, QuestionCategory $questionCategory)
    {
        $questionCategories = \Auth::user()->questionCategories()->notRemoved()->withoutFather()->get();
        $nonRemoved = \Auth::user()->questions()->notRemoved();
        $questions = (isset($questionCategory) ? $nonRemoved->fromCategory($questionCategory) :
            $nonRemoved->withoutCategory())->get();
        return view("question_in_test.form", [
            "test" => $test,
            "questionCategory" => $questionCategory,
            "questionCategories" => $questionCategories,
            "questions" => $questions
        ]);
    }

    /**
     * @param Test $test
     * @param Question $question
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Test $test, Question $question)
    {
        $stored = QuestionsInTests::create([
            "question_id" => $question->id,
            "test_id" => $test->id
        ]);
        return response("", $stored ? 200 : 500);
    }

    /**
     * @param Test $test
     * @param Question $question
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
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
