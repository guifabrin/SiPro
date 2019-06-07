@php
	if (!isset($testCategory))
		$testCategory = isset($test) ? $test->category()->first() : null;
@endphp

@extends('layouts.app')

@section('title', ($test->id ? __('lang.edit') : __('lang.add'))." ".__('lang.test'). ($testCategory ? "[ ".$testCategory->description." ]" : "") )

@section('btn-left')
	<a class="{{config('constants.classes.buttons.back')}}" href="{{ url('test') }}">
		<i class="{{config('constants.classes.icons.back')}}"></i> {{ __('lang.back') }}
	</a>
@endsection

@section('body')
	<form action="{{ url('/test/'.$test->id) }}" method="POST" enctype="multipart/form-data">
		@csrf
		@if (isset($test->id))
			@method("PUT")
		@endif
		<div class="form-group">
			<label for="idText">{{__('lang.id')}}</label>
			<input type="text" name="id" id="idText" value="{{old('id', $test->id)}}" class="form-control" placeholder="{{__('lang.id_placeholder')}}" readonly="true">
		</div>
		<div class="form-group">
			<label for="category_id">{{ __('lang.tests.form.category_id') }}:</label>
			@include('category.tree.select', [
				'father' => false,
				'type'=> 'test',
				'key' => 'category_id',
				'category' => $testCategory,
				'categories' => $testCategories
			])
		</div>
		<div class="form-group">
			<label for="descriptionText">{{__('lang.description')}}</label>
			<textarea name="description" id="descriptionText"
				class="form-control" required="true">{{old('description', $test->description)}}</textarea>
		</div>
		<button class="{{config('constants.classes.buttons.submit')}}">
			<i class="{{config('constants.classes.icons.submit')}}"></i>
			{{__('lang.submit')}}
		</button>
	</form>
	@if ($test->id)
		<iframe src="{{url('/tests/'.$test->id."/questions")}}" frameborder="0"></iframe>
	@endif
@endsection