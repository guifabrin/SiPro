<?php

namespace App\Http\Controllers\Base;

use Auth;
use App\Http\Requests\CategorySaveRequest;
use App\Http\Controllers\ApplicationController;

class CategoryController extends ApplicationController
{

	protected $type;
	protected $class;

	public function create()
	{
		$class = $this->model;
		$categories = $this->categoriesNotRemovedWithoutFather();
		return view("category.form", [
			"type" => $this->type,
			"category" => new $class(),
			"categories" => $categories
		]);
	}

	private function categories()
	{
		return Auth::user()->categories($this->type);
	}

	private function categoriesNotRemovedWithoutFather()
	{
		return $this->categories()->notRemoved()->withoutFather()->get();
	}

	public function edit($category)
	{
		$categories = $this->categoriesNotRemovedWithoutFather();
		return view("category.form", [
			"type" => $this->type,
			"category" => $category,
			"categories" => $categories
		]);
	}

	public function store(CategorySaveRequest $request)
	{
		$input = $request->input();
		$input["user_id"] = Auth::user()->id;
		$input["father_id"] = is_input_null($input["father_id"]) ? null : $input["father_id"];
		$input["soft_delete"] = false;
		$this->model::create($input);
		return redirect(url($this->type . "Category"))->with(['message' => __('lang.stored')]);
	}

	public function update(CategorySaveRequest $request, $category)
	{
		$category = $this->categories()->findOrFail($category->id);
		$input = $request->input();
		$input["father_id"] = is_input_null($input["father_id"]) ? null : $input["father_id"];
		$input["soft_delete"] = false;
		$category->update($input);
		return redirect(url($this->type . "Category"))->with(['message' => __('lang.updated')]);
	}

	public function destroy($category)
	{
		$category = $this->categories()->findOrFail($category->id);
		$category->update([
			"soft_delete" => true
		]);
		return redirect(url($this->type . "Category"))->with(['message' => __('lang.removed')]);
	}

	public function index()
	{
		$categories = $this->categoriesNotRemovedWithoutFather();
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
}
