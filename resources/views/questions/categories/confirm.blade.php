@extends('home')

@section('categories_questions_active') active @endsection

@section('headerbtnl')
	<a class="btn btn-sm btn-primary" href="{{ url('/questions/categories/') }}">
		<i class="fa fa-arrow-circle-left"></i> Voltar
	</a>
@endsection

@section('header')
	Confirmar remoção de Categoria de Questão
@endsection
@section('body')
	{!! Form::open( array('url' => '/questions/categories/'.$categorie->id, 'method' => 'DELETE' )) !!}

		<div class="alert alert-warning">
			Removendo a categoria de questão, você também remove as questões. Caso você tenha algum teste com questões dessa categoria de questão a questão irá ser removida. Tem certeza que deseja remover a categoria de questão '{{$categorie->description}}'?
		</div>

		<p class="yes-no-buttons">
			<button type="submit" class="btn btn-sm btn-info">
			    <i class="fa fa-thumbs-up"></i> Sim
			</button>
			<a class="btn btn-sm btn-info" href="{{ url('/question/categories') }}">
			    <i class="fa fa-thumbs-down"></i> Não
			</a>
		</p>

	{!! Form::close() !!}
@endsection