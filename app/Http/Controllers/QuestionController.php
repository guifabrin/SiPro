<?php

namespace App\Http\Controllers;

use App\Helpers\Boostrap\Alert;
use App\Question;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{

    const DESCRIPTIVE = 0;

    public function index()
    {
        $questions = $this->questionsAll();
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

    public function questionsAll()
    {
        return Auth::user()->questions()->notRemoved()->get();
    }

    public function create()
    {
        $questionCategories = QuestionCategoryController::getUserCategories();
        return view('question.form', [
            'titleKey' => 'add',
            'questionCategory' => null,
            'question' => new Question(),
            'questionCategories' => $questionCategories
        ]);
    }

    public function store(Request $request)
    {
        $stored = QuestionStoreController::store($request);
        $this->message('stored', $stored, true);
        return redirect()->to('question');
    }

    public function show(Question $question)
    {
        return view('question.confirm', [
            'question' => $question,
        ]);
    }

    public function destroy(Question $question)
    {
        $questionObj = $question->update(['soft_delete' => true]);
        $this->message('removed', $questionObj, true);
        return redirect()->to('question');
    }


    public function edit(Question $question)
    {
        $questionCategories = QuestionCategoryController::getUserCategories();
        return view('question.form', [
            'titleKey' => 'edit',
            'questionCategory' => null,
            'question' => $question,
            'questionCategories' => $questionCategories
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $updated = QuestionStoreController::store($request, $question);
        $this->message('updated', $updated, true);
        return redirect()->to('question');
    }
}