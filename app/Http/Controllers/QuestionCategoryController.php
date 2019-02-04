<?php

namespace App\Http\Controllers;

use App\QuestionCategorie;
use Illuminate\Support\Facades\Auth;

class QuestionCategoryController extends CategoryController
{
    protected function type(){
        return 'question';
    }

    protected function typeBasicObj(){
        return new QuestionCategorie();
    }

    protected function getUserCategories()
    {
        return Auth::user()->questionCategories()->withoutFather()->notRemoved()->get();
    }

}