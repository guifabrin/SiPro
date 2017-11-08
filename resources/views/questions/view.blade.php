@extends('home')

@section('questions_active') active @endsection

@section('headerbtnl')
<a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">
<i class="fa fa-btn fa-arrow-circle-left"></i> Voltar
</a>
@endsection

@section('header')
Minhas Questões
@endsection

@section('headerbtnr')
<a class="btn btn-sm btn-success-outline" href="{{ url('home/questions/create/') }}">
    <i class="fa fa-plus"></i> Adicionar
</a>
@endsection

@section('body')

<script src="{{ url('/assets/js/bootstrap-treeview.min.js') }}"></script>
<script src="{{ url('/assets/js/categories.js') }}"></script>
<label style="font-weight: bold;">Categoria de Questões</label>
<div id="tree">
</div>
<input type="hidden" id="categorie_id" onChange="goTo(this.value)"/>

@if(isset($questions) && count($questions)>0)
<div class="container table_responsive">
    <div class="row">
        <div class="col-md-1">
            Código
        </div>
        <div class="col-md-2">
            Categoria
        </div>
        <div class="col-md-2">
            Imagem
        </div>
        <div class="col-md-5">
            Descrição
        </div>
        <div class="col-md-2">
            Ações
        </div>
    </div>
@foreach ($questions as $question)
    <div class="row">
        <div class="col-md-1 col-xs-4">
            <label class="label-xs">Código</label>
            {{ $question->id }}
        </div>
        <div class="col-md-2 col-xs-8">
            <label class="label-xs">Categoria</label>
            @if ($question->categorie_id != 0)
                @foreach ($questionCategories as $questionCategorie)
                    @if ($question->categorie_id == $questionCategorie->id)
                        {{ $questionCategorie->description }}
                    @endif
                @endforeach
            @else
                Nenhuma
            @endif
        </div>
        <div class="col-md-2 col-xs-12">
            <label class="label-xs">Imagem</label>
            <center>
            <?php
                $json = json_decode($question->json);
            ?>
            @if (isset($json->image_name))
                <img style="cursor: pointer;" onclick="show_view_image_modal(this);" src="{{url('/assets/images/uploads/thumbnail/')}}/{{$json->image_name}}" osrc="{{$json->image_name}}" onerror="verify_image(this, '{{$json->image_name}}')"/>
            @else
                <i class="fa fa-camera" aria-hidden="true"></i><br>Sem imagem
            @endif
            </center>
        </div>
        <div class="col-md-5 col-xs-12">
        <label class="label-xs">Descrição</label>
        <?php
        if (isset($json->description))
            echo str_limit($json->description, $limit = 150, $end = '...') ;
        ?>
        </div>
        <div class="col-md-2 col-xs-12">
            <a class="btn btn-sm btn-primary-outline" href="#">
            <i class="fa fa-eye"></i> Ver
            </a>

            <a class="btn btn-sm btn-warning-outline" href="{{ url('home/questions/update/'.$question->id) }}">
            <i class="fa fa-pencil"></i> Editar
            </a>

            <a class="btn btn-sm btn-danger-outline" href="{{ url('home/questions/delete/'.$question->id) }}">
            <i class="fa fa-times"></i> Remover
            </a>
        </div>
    </div>
@endforeach
</div>

<div id="view_image_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ver imagem. 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h4>
            </div>
            <div class="modal-body">
                <img src="{{ url('/assets/images/no_image.jpg') }}" style="width:100%">
            </div>
        </div>
    </div>
</div>

<script>
function show_view_image_modal(thumbnail){
    $('#view_image_modal').find('.modal-body img').attr('src',"{{ url('/assets/images/uploads/') }}/"+ $(thumbnail).attr('osrc'));
    $('#view_image_modal').modal();
}
function verify_image(img, image_name){
    var div = $(img).parent();
    $(img).remove();
    $(div).append("<font color=\"#f0ad4e\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i><br>Erro ao carregar a imagem</font>");
}
</script>
@else
<p class="alert alert-warning" style="margin-top:10px;">Não há nenhuma questão encontrada.</p>
@endif
<div class="container" style="text-align: right;">
@if(isset($prevPageUrl))
    <a class="btn btn-secondary-outline btn-sm" href="{{$prevPageUrl}}"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
@endif
    <button class="btn btn-secondary btn-sm">{{$currentPage}}</button>
@if(isset($nextPageUrl))
    <a class="btn btn-secondary-outline btn-sm" href="{{$nextPageUrl}}"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
@endif
</div>
<script>
$(function(){
    create_tree_categories({
        "show_actions": false,
        "input_result": $("#categorie_id"),
        "continue_childs": true,
        "selected_id": {{$selectedCategorie}},
        "values": $.parseJSON(jsonEscape('{!! json_encode($questionCategories) !!}')),
        "no_one_name" : "Todas"
    });
});

function goTo(id){
    document.location = "{{url('/home/questions/read/')}}/"+id;
}

function jsonEscape(str)  {
    return str.replace(/\n/g, "\\n").replace(/\r/g, "\\r").replace(/\t/g, "\\\\t").replace(/&quot;/g, '\"').replace(//g, '').replace(//g, '');
}
</script>
@endsection