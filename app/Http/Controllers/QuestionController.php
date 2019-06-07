<?php

namespace App\Http\Controllers;

use Auth;
use App\Question;
use App\QuestionCategory;
use Illuminate\Http\Request;
use App\Http\Helpers\QuestionStore;

class QuestionController extends ApplicationController
{

    const DESCRIPTIVE = 0;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $questions = Auth::user()->questions()->notRemoved()->get();
        return self::_index($questions);
    }

    /**
     * @param QuestionCategory|null $questionCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private static function _index($questions, QuestionCategory $questionCategory = null)
    {
        $questionCategories = Auth::user()->questionCategories()->notRemoved()->withoutFather()->get();
        return view("question.view", [
            "questions" => $questions,
            "questionCategory" => $questionCategory,
            "questionCategories" => $questionCategories
        ]);
    }

    /**
     * @param QuestionCategory $questionCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexFromCategory(QuestionCategory $questionCategory)
    {
        $questions = Auth::user()->questions()->notRemoved()->fromCategory($questionCategory)->get();
        return self::_index($questions, $questionCategory);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexWithoutCategory()
    {
        $questions = Auth::user()->questions()->notRemoved()->withoutCategory()->get();
        return self::_index($questions);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return self::_create();
    }

    /**
     * @param QuestionCategory|null $questionCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private static function _create(QuestionCategory $questionCategory = null)
    {
        $questionCategories = Auth::user()->questionCategories()->notRemoved()->withoutFather()->get();
        return view("question.form", [
            "questionCategory" => $questionCategory,
            "question" => new Question(),
            "questionCategories" => $questionCategories
        ]);
    }

    /**
     * @param QuestionCategory $questionCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createFromCategory(QuestionCategory $questionCategory)
    {
        return self::_create($questionCategory);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $stored = QuestionStore::run($request);
        //$this->message("stored", $stored, true);
        return redirect()->to("question");
    }

    /**
     * @param Question $question
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Question $question)
    {
        return view("question.confirm", [
            "question" => $question,
        ]);
    }

    /**
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Question $question)
    {
        $questionObj = $question->update(["soft_delete" => true]);
        //$this->message("removed", $questionObj, true);
        return redirect()->to("question");
    }


    public function edit(Question $question)
    {
        $questionCategories = Auth::user()->questionCategories()->notRemoved()->withoutFather()->get();
        return view("question.form", [
            "questionCategory" => null,
            "question" => $question,
            "questionCategories" => $questionCategories
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $updated = QuestionStore::run($request, $question);
        //$this->message("updated", $updated, true);
        return redirect()->to("question");
    }
}