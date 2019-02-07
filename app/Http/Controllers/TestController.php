<?php

namespace App\Http\Controllers;

use App\Helpers\Boostrap\Alert;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index()
    {
        return self::_index($this->testsAll());
    }

    public static function _index($tests, $testCategory = null){
        $testCategories = TestCategoryController::getUserCategories();
        if ($tests->count() == 0) {
            Alert::build(_v("none_message"), "info");
        }
        return view("test.view", [
            "tests" => $tests,
            "testCategory" => $testCategory,
            "testCategories" => $testCategories
        ]);
    }

    public function testsAll()
    {
        return Auth::user()->tests()->notRemoved()->get();
    }

    public function create()
    {
        $testCategories = TestCategoryController::getUserCategories();
        return view("test.form", [
            "titleKey" => "add",
            "testCategory" => null,
            "test" => new Test(),
            "testCategories" => $testCategories
        ]);
    }

    public function store(Request $request)
    {
        $stored = TestStoreController::store($request);
        $this->message("stored", $stored, true);
        return redirect()->to("test/".$stored->id."/edit");
    }

    public function edit(Test $test)
    {
        $testCategories = TestCategoryController::getUserCategories();
        return view("test.form", [
            "titleKey" => "edit",
            "testCategory" => null,
            "test" => $test,
            "testCategories" => $testCategories
        ]);
    }


    public function update(Request $request, Test $test)
    {
        $stored = TestStoreController::store($request, $test);
        $this->message("stored", $stored, true);
        return redirect()->to("test/".$stored->id."/edit");
    }

}