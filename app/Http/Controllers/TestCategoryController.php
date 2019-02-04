<?php

namespace App\Http\Controllers;

use App\TestCategorie;
use Illuminate\Support\Facades\Auth;

class TestCategoryController extends CategoryController
{

    protected function type(){
       return 'test';
    }

    protected function typeBasicObj(){
        return new TestCategorie();
    }

    protected function getUserCategories()
    {
        return Auth::user()->testCategories()->withoutFather()->notRemoved()->get();
    }

}
