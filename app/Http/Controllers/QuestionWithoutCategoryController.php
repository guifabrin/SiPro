<?php

namespace App\Http\Controllers;

use App\Helpers\Boostrap\Alert;
use App\QuestionCategorie;
use Illuminate\Support\Facades\Auth;

class QuestionWithoutCategoryController extends Controller
{

    public function index()
    {
        return QuestionController::_index(self::questionsWithoutCategory());
    }

    public static function questionsWithoutCategory()
    {
        return Auth::user()->questions()->fromCategory(null)->notRemoved()->get();
    }
}