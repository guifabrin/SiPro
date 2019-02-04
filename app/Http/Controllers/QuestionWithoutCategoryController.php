<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Helpers\Boostrap\Alert;

class QuestionWithoutCategoryController extends Controller {

    public function questionsWithoutCategory(){
        return Auth::user()->questions()->fromCategory(null)->notRemoved()->get();
    }

    public function index() {
        $questions = $this->questionsWithoutCategory();
        $questionCategories = QuestionCategoryController::getUserCategories();
        if ($questions->count() == 0) {
            Alert::build(_v('none_message'), 'info');
        }
        return view('questions.view', [
            'questions' => $questions,
            'questionCategory' => false,
            'questionCategories' => $questionCategories
        ]);
    }
}