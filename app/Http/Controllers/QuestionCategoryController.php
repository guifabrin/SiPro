<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Base\CategoryController;

class QuestionCategoryController extends CategoryController
{

    protected function getUserCategories()
    {
        return Auth::user()->questionCategories()->notRemoved()->withoutFather()->get();
    }

    protected function type()
    {
        return "question";
    }

    protected function typeBasicClass()
    {
        return "App\QuestionCategory";
    }

}