@extends('home')

@section('tests_active') active @endsection

@section('headerbtnl')
<a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">
<i class="fa fa-btn fa-arrow-circle-left"></i> Voltar
</a> 
@endsection

@section('header')
Minhas Provas
@endsection

@section('headerbtnr')
<a class="btn btn-sm btn-success-outline" href="{{ url('home/tests/create/') }}">
<i class="fa fa-plus"></i> Adicionar
</a>
@endsection

@section('body')
@if(isset($tests) && count($tests)>0)
<div class="container table_responsive">
    <div class="row">
        <div class="col-md-1">
            Código
        </div>
        <div class="col-md-2">
            Categoria
        </div>
        <div class="col-md-7">
            Descrição
        </div>
        <div class="col-md-2">
            Ações
        </div>
    </div>
    @foreach ($tests as $test)
    <div class="row">
        <div class="col-md-1 col-xs-4">
            <label class="label-xs">Código</label>
            {{ $test->id }}
        </div>
        <div class="col-md-2 col-xs-8">        
            <label class="label-xs">Categoria</label>
            @if ($test->categorie_id != 0)
                @foreach ($categories as $categorie)
                    @if ($test->categorie_id == $categorie->id)
                        {{ $categorie->description }}
                    @endif
                @endforeach
            @else
                    Nenhuma
            @endif
        </div>
        <div class="col-md-7 col-xs-12">
            <label class="label-xs">Descrição</label>
            <?php
                $json = json_decode($test->json);
            ?>
            {{ $json->description }}
        </div>
        <div class="col-md-2 col-xs-12">
            <a class="btn btn-sm btn-info-outline" href="{{ url('home/tests/show/'.$test->id) }}">
                <i class="fa fa-eye"></i> Ver
            </a>

            <a class="btn btn-sm btn-warning-outline" href="{{ url('home/tests/update/'.$test->id) }}">
            <i class="fa fa-pencil"></i> Editar
            </a>

            <a class="btn btn-sm btn-danger-outline" href="{{ url('home/tests/delete/'.$test->id) }}">
            <i class="fa fa-times"></i> Remover
            </a>
        </div>
    </div>
@endforeach
</div>
@else
<p class="alert alert-warning" style="margin-top:10px;">Não há nenhuma avaliação cadastrada.</p>
@endif
@endsection