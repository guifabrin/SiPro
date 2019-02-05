<?php

namespace App\Http\Controllers;

use App\Helpers\Boostrap\Alert;
use App\Question;
use App\QuestionCategorie;
use Illuminate\Support\Facades\Auth;

class QuestionFromCategoryController extends Controller
{

    public function index(QuestionCategorie $questionCategory)
    {
        return QuestionController::_index(self::questionsFromCategory($questionCategory), $questionCategory);
    }

    public static function questionsFromCategory(QuestionCategorie $questionCategory)
    {
        return Auth::user()->questions()->fromCategory($questionCategory)->notRemoved()->get();
    }

    public function create(QuestionCategorie $questionCategory)
    {
        $questionCategories = QuestionCategoryController::getUserCategories();
        return view('question.form', [
            'titleKey' => 'add',
            'question' => new Question(),
            'questionCategory' => $questionCategory,
            'questionCategories' => $questionCategories
        ]);
    }
}