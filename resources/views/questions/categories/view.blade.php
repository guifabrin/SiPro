@extends('home')

@section('btn-left')
	<a class="btn   btn-primary" href="{{ url('/') }}">
		<i class="fa fa-btn fa-arrow-circle-left"></i> {{ __('lang.back') }}
	</a>
@endsection

@section('header')
	{{ __('lang.mines_gender_a') }} {{ __('lang.question_categories') }}
@endsection

@section('btn-right')
	<a class="btn btn-success" href="{{ url('/questions/categories/create/') }}">
		<i class="fa fa-plus"></i> {{ __('lang.add') }}
	</a>
@endsection

@section('body')
	<ul class="list-group">
		@include('questions.categories.partials.view', ['categories' => $categories, 'nivel' => 1 , 'categorieManage' => true])
	</ul>
@endsection