<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class QuestionCategoryController extends CategoryController
{
    protected function type(){
        return 'question';
    }

    protected function typeBasicClass(){
        return 'App\QuestionCategorie';
    }

    protected function _getUserCategories()
    {
        return Auth::user()->questionCategories()->withoutFather()->notRemoved()->get();
    }

    public static function getUserCategories()
    {
        return (new self())->_getUserCategories();
    }

}