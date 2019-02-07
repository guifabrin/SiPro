<?php

namespace App\Http\Controllers;

use App\Helpers\Boostrap\Alert;
use App\Http\Controllers\Services\TestStore;
use App\Test;
use App\TestCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class TestController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tests = Auth::user()->tests()->notRemoved()->get();
        return self::_index($tests);
    }

    /**
     * @param Collection $tests
     * @param TestCategory|null $testCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function _index(Collection $tests, TestCategory $testCategory = null)
    {
        $testCategories = Auth::user()->testCategories()->notRemoved()->withoutFather()->get();
        if ($tests->count() == 0) {
            Alert::build(_v("none_message"), "info");
        }
        return view("test.view", [
            "tests" => $tests,
            "testCategory" => $testCategory,
            "testCategories" => $testCategories
        ]);
    }

    /**
     * @param TestCategory $testCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexFromCategory(TestCategory $testCategory)
    {
        $tests = Auth::user()->tests()->notRemoved()->fromCategory($testCategory)->get();
        return self::_index($tests, $testCategory);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexWithoutCategory()
    {
        $tests = Auth::user()->tests()->notRemoved()->withoutCategory()->get();
        return self::_index($tests);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return self::_create();
    }

    /**
     * @param null $testCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function _create($testCategory = null)
    {
        $testCategories = Auth::user()->testCategories()->notRemoved()->withoutFather()->get();
        return view("test.form", [
            "titleKey" => "add",
            "test" => new Test(),
            "testCategory" => $testCategory,
            "testCategories" => $testCategories
        ]);
    }

    /**
     * @param TestCategory $testCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createFromCategory(TestCategory $testCategory)
    {
        return self::_create($testCategory);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $stored = TestStore::run($request);
        $this->message("stored", $stored, true);
        return redirect()->to("test/" . $stored->id . "/edit");
    }

    /**
     * @param Test $test
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Test $test)
    {
        $testCategories = Auth::user()->testCategories()->notRemoved()->withoutFather()->get();
        return view("test.form", [
            "titleKey" => "edit",
            "testCategory" => null,
            "test" => $test,
            "testCategories" => $testCategories
        ]);
    }


    /**
     * @param Request $request
     * @param Test $test
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Test $test)
    {
        $stored = TestStore::run($request, $test);
        $this->message("stored", $stored, true);
        return redirect()->to("test/" . $stored->id . "/edit");
    }

    /**
     * @param Test $test
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Test $test)
    {
        return view("test.confirm", [
            "test" => $test,
        ]);
    }

    /**
     * @param Test $test
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Test $test)
    {
        $testObj = $test->update(["soft_delete" => true]);
        $this->message("removed", $testObj, true);
        return redirect()->to("test");
    }

}