<?php

namespace App\Http\Controllers\Base;

use App\Helpers\Boostrap\Alert;
use App\Http\Controllers\ApplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends ApplicationController
{
    public function create()
    {
        $categories = $this->getUserCategories();
        $class = $this->typeBasicClass();
        return view("category.form", [
            "type" => $this->type(),
            "category" => new $class(),
            "categories" => $categories
        ]);
    }

    protected function getUserCategories()
    {
        throw new \Exception(_v("need_implement_getUserCategories"));
    }

    protected function typeBasicClass()
    {
        throw new \Exception(_v("need_implement_typeBasicClass"));
    }

    protected function type()
    {
        throw new \Exception(_v("need_implement_type"));
    }

    public function edit($category)
    {
        $categories = $this->getUserCategories();
        return view("category.form", [
            "type" => $this->type(),
            "category" => $category,
            "categories" => $categories
        ]);
    }

    public function store(Request $request)
    {
        Alert::clear();
        $this->validate($request);
        $categoryObj = $this->save($request->input());
        $this->message("created", $categoryObj);
        return redirect()->to($this->type() . "Category");
    }

    public function validate(Request $request, array $rules = [], array $messages = [], array $customAttributes = [])
    {
        $request->validate([
            "description" => "required",
        ]);
    }

    private function save(array $input = [], $category = null)
    {
        $input["user_id"] = Auth::user()->id;
        process_if_null($input["father_id"]);
        $input["soft_delete"] = isset($input["soft_delete"]) ? $input["soft_delete"] : false;
        if (empty($category)) {
            return $this->typeBasicClass()::create($input);
        } else {
            $category->update($input);
            return $category;
        }
    }

    public function index()
    {
        $categories = $this->getUserCategories();
        if ($categories->count() == 0) {
            Alert::build(_v("none_message"), "info");
        }
        return view("category.view", [
            "type" => $this->type(),
            "categories" => $categories
        ]);
    }

    public function show($category)
    {
        return view("category.confirm", [
            "type" => $this->type(),
            "category" => $category,
        ]);
    }

    public function destroy($category)
    {
        $categoryObj = $this->save(["soft_delete" => true], $category);
        $this->message("removed", $categoryObj);
        return redirect()->to($this->type() . "Category");
    }

    public function update(Request $request, $category)
    {
        Alert::clear();
        $this->validate($request);
        $categoryObj = $this->save($request->input(), $category);
        $this->message("updated", $categoryObj);
        return redirect()->to($this->type() . "Category");
    }
}
