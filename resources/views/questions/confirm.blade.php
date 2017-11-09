@extends('home')

@section('questions_active') active @endsection

@section('headerbtnl')
	<a class="btn btn-sm btn-primary" href="{{ url('questions') }}">
		<i class="fa fa-btn fa-arrow-circle-left"></i> Voltar
	</a>
@endsection

@section('header')
	Confirmar remoção de Questão
@endsection
@section('body')
	{!! Form::open( array('url' => '/questions/'.$question->id, 'method' => 'DELETE' ) ) !!}
		<div class="alert alert-warning">
			Caso você tenha esta questão em algum teste a questão irá ser removida do teste. Tem certeza que deseja remover a  questão '{{$question->description}}' de Identificador {{$question->id}}?
		</div>

		<p class="yes-no-buttons">
			<button type="submit" class="btn btn-sm btn-info">
			    <i class="fa fa-thumbs-up"></i> Sim
			</button>
			<a class="btn btn-sm btn-info" href="{{ url('questions') }}">
			    <i class="fa fa-thumbs-down"></i> Não
			</a>
		</p>
	{!! Form::close() !!}
@endsection