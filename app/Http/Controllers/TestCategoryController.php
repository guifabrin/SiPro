<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class TestCategoryController extends CategoryController
{

    protected function type(){
       return 'test';
    }

    protected function typeBasicClass(){
        return 'App\TestCategorie';
    }

    protected function _getUserCategories()
    {
        return Auth::user()->testCategories()->withoutFather()->notRemoved()->get();
    }

    public static function getUserCategories()
    {
        return (new self())->_getUserCategories();
    }

}
