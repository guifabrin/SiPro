<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\ApplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends ApplicationController
{

	protected $type;
	protected $class;

	public function create()
	{
		$class = $this->model;
		$categories = $this->categories();
		return view("category.form", [
			"type" => $this->type,
			"category" => new $class(),
			"categories" => $categories
		]);
	}

	private function categories()
	{
		return Auth::user()->categories($this->type)->notRemoved()->withoutFather()->get();
	}

	public function edit($category)
	{
		$categories = $this->categories();
		return view("category.form", [
			"type" => $this->type,
			"category" => $category,
			"categories" => $categories
		]);
	}

	public function store(Request $request)
	{
		$this->validate($request);
		$categoryObj = $this->save($request->input());
		//$this->message("created", $categoryObj);
		return redirect()->to($this->type . "Category");
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
			return $this->model::create($input);
		} else {
			$category->update($input);
			return $category;
		}
	}

	public function index()
	{
		$categories = $this->categories();
		return view("category.view", [
			"type" => $this->type,
			"categories" => $categories
		]);
	}

	public function show($category)
	{
		return view("category.confirm", [
			"type" => $this->type,
			"category" => $category,
		]);
	}

	public function destroy($category)
	{
		$categoryObj = $this->save(["soft_delete" => true], $category);
		//$this->message("removed", $categoryObj);
		return redirect()->to($this->type . "Category");
	}

	public function update(Request $request, $category)
	{
		$this->validate($request);
		$categoryObj = $this->save($request->input(), $category);
		//$this->message("updated", $categoryObj);
		return redirect()->to($this->type . "Category");
	}
}
