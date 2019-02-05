<?php

namespace App\Http\Controllers;

use App\Helpers\Boostrap\Alert;
use Illuminate\Support\Facades\Auth;

class QuestionWithoutCategoryController extends Controller
{

    public function index()
    {
        $questions = $this->questionsWithoutCategory();
        $questionCategories = QuestionCategoryController::getUserCategories();
        if ($questions->count() == 0) {
            Alert::build(_v('none_message'), 'info');
        }
        return view('question.view', [
            'questions' => $questions,
            'questionCategory' => null,
            'questionCategories' => $questionCategories
        ]);
    }

    public function questionsWithoutCategory()
    {
        return Auth::user()->questions()->fromCategory(null)->notRemoved()->get();
    }
}