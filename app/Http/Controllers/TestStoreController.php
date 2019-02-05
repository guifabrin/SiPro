<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestStoreController extends Controller
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

    public static function store(Request $request, Test $test = null)
    {
        return (new self($request, $test))->_store();
    }

    public function _store()
    {
        $this->validate($this->request);
        return $this->processTest();
    }

    public function validate(Request $_request, array $_rules = [], array $_messages = [],
                             array $_customAttributes = [])
    {
        $this->request->validate([
            'description' => 'required'
        ]);
    }

    private function processTest()
    {
        $args = [
            "categorie_id" => $this->getTestCategoryId(),
            "user_id" => Auth::user()->id,
            "description" => $this->input['description'],
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
        $testCategoryId = $this->input['categorie_id'];
        processIfNull($testCategoryId);
        $testCategory = Auth::user()->testCategories()->where('id', $testCategoryId)->first();
        return isset($testCategory) ? $testCategory->id : null;
    }
}