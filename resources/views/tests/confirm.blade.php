@extends('home')

@section('btn-left')
<a class="btn   btn-primary" href="{{ URL::previous() }}">
<i class="fa fa-arrow-circle-left"></i> {{ __('lang.back') }}
</a>
@endsection

@section('header')
Confirmar remoção de {{ __('lang.test') }}
@endsection

@section('body')
{!! Form::open(array('method' => 'post')) !!}
Tem certeza que deseja remover a avaliação
<?php
try {
	$json = json_decode($test->json);
	echo "'" . $json->description . "'";
} catch (Exception $e) {
	echo " de Identificador " . $test->id;
}

?>
{{ Form::hidden('id', $test->id, ['class' => 'form-control', 'readonly' => 'true']) }}
{{ Form::hidden('soft_delete', 1 , ['class' => 'form-control', 'readonly' => 'true']) }}
<p class="yes-no-buttons">
<button type="submit" class="btn   btn-info">
    <i class="fa fa-thumbs-up"></i> Sim
</button>
<a class="btn   btn-info" href="{{ url('lang.tests/') }}">
    <i class="fa fa-thumbs-down"></i> Não
</a>
</p>

{!! Form::close() !!}
@endsection