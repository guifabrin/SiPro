@php
	if (!isset($itemCategory))
		$itemCategory = isset($item) ? $item->category()->first() : null;
@endphp

@extends('layouts.app')

@section('title', ($item->id ? __('lang.edit') : __('lang.add'))." ".__('lang.test'). ($itemCategory ? "[ ".$itemCategory->description." ]" : "") )

@section('btn-left')
	<a class="{{config('constants.classes.buttons.back')}}" href="{{ url('test') }}">
		<i class="{{config('constants.classes.icons.back')}}"></i> {{ __('lang.back') }}
	</a>
@endsection

@section('body')
	<form action="{{ url('/test/'.$item->id) }}" method="POST" enctype="multipart/form-data">
		@csrf
		@if (isset($item->id))
			@method("PUT")
		@endif
		<div class="form-group">
			<label for="idText">{{__('lang.id')}}</label>
			<input type="text" name="id" id="idText" value="{{old('id', $item->id)}}" class="form-control" placeholder="{{__('lang.id_placeholder')}}" readonly="true">
		</div>
		<div class="form-group">
			<label for="category_id">{{ __('lang.tests.form.category_id') }}:</label>
			@include('category.tree.select', [
				'father' => false,
				'type'=> 'test',
				'key' => 'category_id',
				'category' => $itemCategory,
				'categories' => $itemCategories
			])
		</div>
		<div class="form-group">
			<label for="descriptionText">{{__('lang.description')}}</label>
			<textarea name="description" id="descriptionText"
				class="form-control" required="true">{{old('description', $item->description)}}</textarea>
		</div>
		<button class="{{config('constants.classes.buttons.submit')}}">
			<i class="{{config('constants.classes.icons.submit')}}"></i>
			{{__('lang.submit')}}
		</button>
	</form>
	@if ($item->id)
		<iframe src="{{url('/tests/'.$item->id."/questions")}}" frameborder="0"></iframe>
	@endif
@endsection