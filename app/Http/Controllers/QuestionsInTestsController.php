<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionCategorie;
use App\QuestionsInTests;
use App\Test;
use Illuminate\Http\Request;

class QuestionsInTestsController extends Controller
{
    public function index(Test $test, QuestionCategorie $questionCategory){
        $questionCategories = QuestionCategoryController::getUserCategories();
        if (!isset($questionCategory)){
            $questions = QuestionWithoutCategoryController::questionsWithoutCategory();
        } else {
            $questions = QuestionFromCategoryController::questionsFromCategory($questionCategory);
        }
        return view('question_in_test.form', [
            'test' => $test,
            'questionCategory' => $questionCategory,
            'questionCategories' => $questionCategories,
            'questions' => $questions
        ]);
    }


    public function store(Test $test, Question $question)
    {
        $qt = QuestionsInTests::create([
            'question_id' => $question->id,
            'test_id' => $test->id
        ]);
        return response('', $qt ? 200 : 500);
    }

    public function destroy(Test $test, Question $question)
    {
        $qt = QuestionsInTests::where([
            'question_id' => $question->id,
            'test_id' => $test->id
        ]);
        $delete = $qt->delete();
        return response($delete?'ok':'err', $delete ? 200 : 500);
    }
}
