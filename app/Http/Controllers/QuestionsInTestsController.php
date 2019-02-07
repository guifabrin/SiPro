<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionCategory;
use App\QuestionsInTests;
use App\Test;

class QuestionsInTestsController extends Controller
{
    public function index(Test $test, QuestionCategory $questionCategory)
    {
        $questionCategories = QuestionCategoryController::getUserCategories();
        if (!isset($questionCategory)) {
            $questions = QuestionWithoutCategoryController::questionsWithoutCategory();
        } else {
            $questions = QuestionFromCategoryController::questionsFromCategory($questionCategory);
        }
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
