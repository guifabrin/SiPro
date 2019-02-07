<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class QuestionCategoryController extends CategoryController
{
    public static function getUserCategories()
    {
        return (new self())->_getUserCategories();
    }

    protected function _getUserCategories()
    {
        return Auth::user()->questionCategories()->withoutFather()->notRemoved()->get();
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