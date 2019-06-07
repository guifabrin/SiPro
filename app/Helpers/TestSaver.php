<?php

namespace App\Http\Helpers;

use Auth;
use App\Test;
use Illuminate\Http\Request;

class TestSaver {

    private $test;
    private $input;
    private $request;

    public function __construct(Request $request, Test $test = null) {
        $this->request = $request;
        $this->input = $request->all();
        $this->test = $test ? $test : new Test();
    }

    public static function run(Request $request, Test $test = null) {
        return (new self($request, $test))->store();
    }

    private function getTestCategoryId() {
        if (is_input_null($this->input["category_id"])) return null;
        $testCategory = Auth::user()->testCategories()->find($this->input["category_id"]);
        return $testCategory ? $testCategory->id : null;
    }

    private function parameters() {
        return [
            "soft_delete" => false,
            "user_id" => Auth::user()->id,
            "category_id" => $this->getTestCategoryId(),
            "description" => $this->input["description"]
        ];
    }

    public function store() {
        $this->validate();
        $this->test->fill($this->parameters());
        $this->test->save();
        return $this->test;
    }

    public function validate() {
        $this->request->validate([
            "description" => "required"
        ]);
    }
}
