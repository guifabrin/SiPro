@extends('home')

@section('btn-left')
	<a class="btn   btn-primary" href="{{ url('/') }}">
		<i class="fa fa-btn fa-arrow-circle-left"></i> {{ __('lang.back') }}
	</a>
@endsection

@section('header')
	{{ __('lang.mines_gender_a') }} {{ __('lang.categorie') }}s de {{ __('lang.test') }}
@endsection

@section('btn-right')
	<a class="btn   btn-success-outline" href="{{ url('/tests/categories/create/') }}">
		<i class="fa fa-plus"></i> {{ __('lang.add') }}
	</a>
@endsection

@section('body')
	<ul class="list-group">
		@include('tests.categories.partials.view', ['categories' => $categories, 'nivel' => 1 , 'categorieManage' => true])
	</ul>
@endsection