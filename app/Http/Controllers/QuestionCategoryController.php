<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\CategoryController;
use Illuminate\Support\Facades\Auth;

class QuestionCategoryController extends CategoryController
{

    /**
     * Function to return all question's categories not removed and withour father to mount tree.
     */
    protected function getUserCategories()
    {
        return Auth::user()->questionCategories()->notRemoved()->withoutFather()->get();
    }

    /**
     * Function to return type of this category
     * @return string
     */
    protected function type()
    {
        return "question";
    }

    /**
     * Function to return base class name of category
     *
     * @return string
     */
    protected function typeBasicClass()
    {
        return "App\QuestionCategory";
    }

}