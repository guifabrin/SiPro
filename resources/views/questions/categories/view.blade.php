@extends('home')

@section('categories_questions_active') active @endsection

@section('headerbtnl')
<a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">
<i class="fa fa-btn fa-arrow-circle-left"></i> Voltar
</a>
@endsection

@section('header')
Minhas Categorias de Questão
@endsection

@section('headerbtnr')
<a class="btn btn-sm btn-success-outline" href="{{ url('/home/questions/categories/create/') }}">
	<i class="fa fa-plus"></i> Adicionar
</a>
@endsection

@section('body')
	@if(isset($categories) && count($categories)>0)
	<script src="{{ url('/assets/js/bootstrap-treeview.min.js') }}"></script>
	<script src="{{ url('/assets/js/categories.js') }}"></script>

	<link href="{{ url('/assets/css/bootstrap-treeview.min.css') }}" rel="stylesheet">
	<div id="tree" style="margin-top:10px;"></div>
	<input type="hidden" id="tree_val">
	<script>
		$(function(){
			create_tree_categories({
				"show_actions": true,
				"input_result": $("#tree_val"),
				"continue_childs": true,
				"update_page": '{{url("/home/questions/categories/update")}}',
				"delete_page": '{{url("/home/questions/categories/delete")}}', 
				"create_item_page": '{{url("/home/questions/create/")}}', 
				"create_item_title": "Questão",
				"selected_id": -1,
				"values": $.parseJSON(("{{ json_encode($categories) }}").replace(/&quot;/g, '\"'))
			});
		});
	</script>
	@else
	<p class="alert alert-warning" style="margin-top:10px;">Não há nenhuma categoria de questão cadastrada.</p>
	@endif
@endsection