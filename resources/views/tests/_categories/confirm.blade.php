@extends('home')

@section('categories_tests_active') active @endsection

@section('btn-left')
	<a class="btn   btn-primary" href="{{ url('/tests/categories/') }}">
		<i class="fa fa-arrow-circle-left"></i> {{ __('lang.back') }}
	</a>
@endsection

@section('header')
	Confirmar remoção de {{ __('lang.categorie') }} de teste
@endsection
@section('body')
	{!! Form::open( array('url' => '/tests/categories/'.$categorie->id, 'method' => 'DELETE' )) !!}

		<div class="alert alert-warning">
			Removendo a categoria de teste, você também remove os testes. Tem certeza que deseja remover a categoria de teste '{{$categorie->description}}'?
		</div>

		<p class="yes-no-buttons">
			<button type="submit" class="btn   btn-info">
			    <i class="fa fa-thumbs-up"></i> Sim
			</button>
			<a class="btn   btn-info" href="{{ url('/tests/categories') }}">
			    <i class="fa fa-thumbs-down"></i> Não
			</a>
		</p>

	{!! Form::close() !!}
@endsection