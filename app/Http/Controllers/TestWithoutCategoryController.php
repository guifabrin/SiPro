<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class TestWithoutCategoryController extends Controller
{

    public function index()
    {
        return TestController::_index(self::testsWithoutCategory());
    }

    public static function testsWithoutCategory()
    {
        return Auth::user()->tests()->withoutCategory()->notRemoved()->get();
    }
}