@extends('home')

@section('questions_active') active @endsection

@section('headerbtnl')
<a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">
<i class="fa fa-btn fa-arrow-circle-left"></i> Voltar
</a>
@endsection

@section('header')
Confirmar remoção de Questão
@endsection
@section('body')
{!! Form::open(array('method' => 'post')) !!}
Caso você tenha esta questão em algum teste a questão irá ser removida do teste. Tem certeza que deseja remover a  questão <?php

try {
    $json = json_decode($question->json);
    echo "'".$json->description."'";
} catch (Exception $e) {
    echo " de Identificador ".$question->id;
}
?>? 
{{ Form::hidden('id', $question->id, ['class' => 'form-control', 'readonly' => 'true']) }}
{{ Form::hidden('soft_delete', 1 , ['class' => 'form-control', 'readonly' => 'true']) }}
<p class="yes-no-buttons">
	<button type="submit" class="btn btn-sm btn-info">
	    <i class="fa fa-thumbs-up"></i> Sim
	</button>
	<a class="btn btn-sm btn-info" href="{{ url('home/questions/') }}">
	    <i class="fa fa-thumbs-down"></i> Não
	</a>
</p>
{!! Form::close() !!}
@endsection