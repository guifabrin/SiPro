<?php

namespace App\Http\Helpers;

use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestStore
{

    private $request;
    private $input;
    private $test;

    public function __construct(Request $request, Test $test = null)
    {
        $this->request = $request;
        $this->input = $request->all();
        if ($test) {
            $this->test = $test;
        }
    }

    public static function run(Request $request, Test $test = null)
    {
        return (new self($request, $test))->store();
    }

    public function store()
    {
        $this->validate();
        return $this->processTest();
    }

    public function validate()
    {
        $this->request->validate([
            "description" => "required"
        ]);
    }

    private function processTest()
    {
        $args = [
            "category_id" => $this->getTestCategoryId(),
            "user_id" => Auth::user()->id,
            "description" => $this->input["description"],
            "soft_delete" => false
        ];
        if ($this->test) {
            $this->test->update($args);
        } else {
            $this->test = Test::create($args);
        }
        return $this->test;
    }

    private function getTestCategoryId()
    {
        $testCategoryId = $this->input["category_id"];
        process_if_null($testCategoryId);
        $testCategory = Auth::user()->testCategories()->where("id", $testCategoryId)->first();
        return isset($testCategory) ? $testCategory->id : null;
    }
}