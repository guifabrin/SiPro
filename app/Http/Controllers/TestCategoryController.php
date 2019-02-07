<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Base\CategoryController;

class TestCategoryController extends CategoryController
{

    protected function getUserCategories()
    {
        return Auth::user()->testCategories()->notRemoved()->withoutFather()->get();
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
