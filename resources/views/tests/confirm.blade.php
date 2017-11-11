@extends('home')

@section('tests_active') active @endsection

@section('headerbtnl')
<a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">
<i class="fa fa-arrow-circle-left"></i> Voltar
</a> 
@endsection

@section('header')
Confirmar remoção de Prova
@endsection

@section('body')
{!! Form::open(array('method' => 'post')) !!}
Tem certeza que deseja remover a avaliação
<?php
try {
    $json = json_decode($test->json);
    echo "'".$json->description."'";
} catch (Exception $e) {
    echo " de Identificador ".$test->id;
}

?>
{{ Form::hidden('id', $test->id, ['class' => 'form-control', 'readonly' => 'true']) }}
{{ Form::hidden('soft_delete', 1 , ['class' => 'form-control', 'readonly' => 'true']) }}
<p class="yes-no-buttons">
<button type="submit" class="btn btn-sm btn-info">
    <i class="fa fa-thumbs-up"></i> Sim
</button>
<a class="btn btn-sm btn-info" href="{{ url('home/tests/') }}">
    <i class="fa fa-thumbs-down"></i> Não
</a>
</p>

{!! Form::close() !!}
@endsection