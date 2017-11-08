@extends('home')

@section('categories_questions_active') active @endsection

@section('header')
<a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">
<i class="fa fa-arrow-circle-left"></i> Voltar
</a> 
@endsection

@section('header')
Confirmar remoção de Categoria de Questão
@endsection
@section('body')
{!! Form::open(array('method' => 'post')) !!}
Removendo a categoria de questão, você também remove as questões. Caso você tenha algum teste com questões dessa categoria de questão a questão irá ser removida. Tem certeza que deseja remover a categoria de questão '{{$question->description}}'?
{{ Form::hidden('id', $question->id, ['class' => 'form-control', 'readonly' => 'true']) }}
{{ Form::hidden('father_id', $question->father_id, ['class' => 'form-control', 'readonly' => 'true']) }}
{{ Form::hidden('soft_delete', 1 , ['class' => 'form-control', 'readonly' => 'true']) }}
<p class="yes-no-buttons">
	<button type="submit" class="btn btn-sm btn-info">
	    <i class="fa fa-thumbs-up"></i> Sim
	</button>
	<a class="btn btn-sm btn-info" href="{{ url('home/question/categories/') }}">
	    <i class="fa fa-thumbs-down"></i> Não
	</a>
</p>
{!! Form::close() !!}
@endsection