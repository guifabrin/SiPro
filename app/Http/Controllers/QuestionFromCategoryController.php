<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionCategory;
use Illuminate\Support\Facades\Auth;

class QuestionFromCategoryController extends Controller
{

    public function index(QuestionCategory $questionCategory)
    {
        return QuestionController::_index(self::questionsFromCategory($questionCategory), $questionCategory);
    }

    public static function questionsFromCategory(QuestionCategory $questionCategory)
    {
        return Auth::user()->questions()->fromCategory($questionCategory)->notRemoved()->get();
    }

    public function create(QuestionCategory $questionCategory)
    {
        $questionCategories = QuestionCategoryController::getUserCategories();
        return view("question.form", [
            "titleKey" => "add",
            "question" => new Question(),
            "questionCategory" => $questionCategory,
            "questionCategories" => $questionCategories
        ]);
    }
}