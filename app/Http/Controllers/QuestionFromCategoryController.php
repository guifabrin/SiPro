<?php

namespace App\Http\Controllers;

use App\QuestionCategorie;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Boostrap\Alert;
use App\Question;

class QuestionFromCategoryController extends Controller {

    public function questionsFromCategory($questionCategory){
        return Auth::user()->questions()->fromCategory($questionCategory)->notRemoved()->get();
    }

    public function index(QuestionCategorie $questionCategory) {
        $questions = $this->questionsFromCategory($questionCategory);
        $questionCategories = QuestionCategoryController::getUserCategories();
        if ($questions->count() == 0) {
            Alert::build(_v('none_message'), 'info');
        }
        return view('questions.view', [
            'questions' => $questions,
            'questionCategory' => $questionCategory,
            'questionCategories' => $questionCategories
        ]);
    }


    public function create(QuestionCategorie $questionCategory)
    {
        $questionCategories = QuestionCategoryController::getUserCategories();
        return view('questions.form', [
            'titleKey' => 'add',
            'question' => new Question(),
            'questionCategory' => $questionCategory,
            'questionCategories' => $questionCategories
        ]);
    }
}