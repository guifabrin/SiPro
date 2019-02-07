<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class TestCategoryController extends CategoryController
{

    public static function getUserCategories()
    {
        return (new self())->_getUserCategories();
    }

    protected function _getUserCategories()
    {
        return Auth::user()->testCategories()->withoutFather()->notRemoved()->get();
    }

    protected function type()
    {
        return "test";
    }

    protected function typeBasicClass()
    {
        return "App\TestCategory";
    }

}
