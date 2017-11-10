@extends('home')

@section('categories_tests_active') active @endsection

@section('headerbtnl')
	<a class="btn btn-sm btn-primary" href="{{ url('/tests/categories/') }}">
		<i class="fa fa-arrow-circle-left"></i> Voltar
	</a>
@endsection

@section('header')
	Confirmar remoção de Categoria de teste
@endsection
@section('body')
	{!! Form::open( array('url' => '/tests/categories/'.$categorie->id, 'method' => 'DELETE' )) !!}

		<div class="alert alert-warning">
			Removendo a categoria de teste, você também remove os testes. Tem certeza que deseja remover a categoria de teste '{{$categorie->description}}'?
		</div>

		<p class="yes-no-buttons">
			<button type="submit" class="btn btn-sm btn-info">
			    <i class="fa fa-thumbs-up"></i> Sim
			</button>
			<a class="btn btn-sm btn-info" href="{{ url('/tests/categories') }}">
			    <i class="fa fa-thumbs-down"></i> Não
			</a>
		</p>

	{!! Form::close() !!}
@endsection