<?php

namespace App\Http\Controllers;

use App\Helpers\Boostrap\Alert;
use App\Test;
use App\TestCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index()
    {
        $tests = Auth::user()->tests()->notRemoved()->get();
        return self::_index($tests);
    }

    public static function _index($tests, $testCategory = null)
    {
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

    public function indexFromCategory(TestCategory $testCategory)
    {
        $tests = Auth::user()->tests()->notRemoved()->fromCategory($testCategory)->get();
        return self::_index($tests, $testCategory);
    }

    public function indexWithoutCategory()
    {
        $tests = Auth::user()->tests()->notRemoved()->withoutCategory()->get();
        return self::_index($tests);
    }

    public function create()
    {
        return self::_create();
    }

    public static function _create($testCategory = null)
    {
        $testCategories = TestCategoryController::getUserCategories();
        return view("test.form", [
            "titleKey" => "add",
            "test" => new Test(),
            "testCategory" => $testCategory,
            "testCategories" => $testCategories
        ]);
    }

    public function createFromCategory(TestCategory $testCategory)
    {
        return self::_create($testCategory);
    }

    public function store(Request $request)
    {
        $stored = TestStoreController::store($request);
        $this->message("stored", $stored, true);
        return redirect()->to("test/" . $stored->id . "/edit");
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
        return redirect()->to("test/" . $stored->id . "/edit");
    }

    public function show(Test $test)
    {
        return view("test.confirm", [
            "test" => $test,
        ]);
    }

    public function destroy(Test $test)
    {
        $testObj = $test->update(["soft_delete" => true]);
        $this->message("removed", $testObj, true);
        return redirect()->to("test");
    }

}