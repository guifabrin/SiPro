<?php

namespace App\Http\Controllers;

use App\Question;
use App\TestCategory;
use Illuminate\Support\Facades\Auth;

class TestFromCategoryController extends Controller
{

    public function index(TestCategory $testCategory)
    {
        return TestController::_index(self::testsFromCategory($testCategory), $testCategory);
    }

    public static function testsFromCategory(TestCategory $testCategory)
    {
        return Auth::user()->tests()->fromCategory($testCategory)->notRemoved()->get();
    }

    public function create(TestCategory $testCategory)
    {
        $testCategories = TestCategoryController::getUserCategories();
        return view("test.form", [
            "titleKey" => "add",
            "test" => new Question(),
            "testCategory" => $testCategory,
            "testCategories" => $testCategories
        ]);
    }
}