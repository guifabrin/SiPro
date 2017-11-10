@extends('home')

@section('categories_tests_active') active @endsection

@section('headerbtnl')
	<a class="btn btn-sm btn-primary" href="{{ url('/') }}">
		<i class="fa fa-btn fa-arrow-circle-left"></i> Voltar
	</a>
@endsection

@section('header')
	Minhas Categorias de Teste
@endsection

@section('headerbtnr')
	<a class="btn btn-sm btn-success-outline" href="{{ url('/tests/categories/create/') }}">
		<i class="fa fa-plus"></i> Adicionar
	</a>
@endsection

@section('body')
	<ul class="list-group">
		@include('tests.categories.partials.view', ['categories' => $categories, 'nivel' => 1 , 'categorieManage' => true])
	</ul>
@endsection