<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\CategoryController;
use Illuminate\Support\Facades\Auth;

class TestCategoryController extends CategoryController
{

    /**
     * Function to return all tests's categories not removed and withour father to mount tree.
     */
    protected function getUserCategories()
    {
        return Auth::user()->testCategories()->notRemoved()->withoutFather()->get();
    }

    /**
     * Function to return type of this category
     * @return string
     */
    protected function type()
    {
        return "test";
    }

    /**
     * Function to return base class name of category
     *
     * @return string
     */
    protected function typeBasicClass()
    {
        return "App\TestCategory";
    }

}
