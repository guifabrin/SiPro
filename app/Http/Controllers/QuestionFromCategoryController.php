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
        $questions = $this->questionsFromCategory($questionCategory);
        $questionCategories = QuestionCategoryController::getUserCategories();
        if ($questions->count() == 0) {
            Alert::build(_v('none_message'), 'info');
        }
        return view('question.view', [
            'questions' => $questions,
            'questionCategory' => $questionCategory,
            'questionCategories' => $questionCategories
        ]);
    }

    public function questionsFromCategory($questionCategory)
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