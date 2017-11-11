@extends('home')

@section('tests_active') active @endsection

@section('headerbtnl')
<a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">
	<i class="fa fa-arrow-circle-left"></i> Voltar
</a> 
@endsection

@section('header')
{{ $title }} Prova
@endsection

@section('body')

<script src="{{ url('/assets/js/bootstrap-treeview.min.js') }}"></script>
<script src="{{ url('/assets/js/categories.js') }}"></script>

{!! Form::open(['method' => 'post' , 'id' => 'test_form']) !!}
<div class="panel">
	@if(isset($test))
	<h2 class="panel-heading">
		Prova Código {{ $test->id }}
		<button type="button" class="btn btn-sm btn-default pull-right" onclick="show_panel_body(this)">
			<i class="fa fa-chevron-down"></i>
		</button>
	</h2>
	{{ Form::hidden('id', (isset($test))?$test->id:null, ['class' => 'form-control', 'readonly' => 'true']) }}
	<div class="panel-body" style="display:none;">
		@else
		<div class="panel-body">
			<div class="form-group">
				{{ Form::label('id','Código:', ['class' => 'control-label']) }}
				{{ Form::text('id', (isset($test))?$test->id:null, ['class' => 'form-control', 'readonly' => 'true']) }}
			</div>
			@endif
			<div class="form-group">
				{{ Form::label('test_categorie_id','Categoria do Prova:', ['class' => 'control-label']) }}
				<div id="tree_tests_categorie"></div>
				<input type="hidden" id="test_categorie_id" name="categorie_id">
			</div>
			<div class="form-group">
				{{ Form::label('description','Descrição:', ['class' => 'control-label']) }}
				<textarea class='form-control' id="description"></textarea>
			</div>

			{{ Form::hidden('json', (isset($test))?$test->json:null, ['class' => 'form-control', 'placeholder' => '{}', 'required' => 'true']) }}

			<div class="form-group">
				<button type="button" class="btn btn-sm btn-success" onclick="make_json();">
					<i class="fa fa-floppy-o"></i> Salvar
				</button>
			</div>

			<div id="saving_modal" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Salvando prova.</h4>
						</div>
						<div class="modal-body">
							<p>Some text in the modal.</p>
							<div class="progress">
								<div class="progress-bar progress-bar-striped active" role="progressbar"
								aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="view_image_modal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ver imagem. 
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</h4>
					</div>
					<div class="modal-body">
						<img src="{{ url('/assets/images/no_image.jpg') }}" style="max-width:100%"/>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}
<script>
	function make_json(){
		$("#saving_modal").modal({
			backdrop: 'static',
			keyboard: false
		});
		$("#saving_modal").modal("show");
		$("#saving_modal").find(".modal-body p").text("Criando estrutura de prova...");
		var test = {};
		test.description = $('#description').val();
		$("input[name=json]").val(JSON.stringify(test));
		$("#saving_modal").find(".modal-body p").text("Salvando prova...");
		$("#test_form").submit();
	}

	$(function(){
		var json_string = "{{(isset($test))?$test->json:null}}";
		if (json_string!=""){
			var json_obj = $.parseJSON(json_string.replace(/&quot;/g, '\"'));
			$('#description').val(json_obj.description);
		}

		<?php
		$selected_id = 0;
		if (isset($test)){
			$selected_id = $test->categorie_id;
		} else {
			if (isset($selected_categorie)){
				$selected_id = $selected_categorie;
			}
		}
		?>
		create_tree_categories({
			"tree_id":"tree_tests_categorie",
			"show_actions": false,
			"input_result": $("#test_categorie_id"),
			"continue_childs": true,
			"selected_id": {{$selected_id}},
			"values":$.parseJSON(("{{ json_encode($test_categories) }}").replace(/&quot;/g, '\"'))
		});
	});
</script>

@if (isset($test) && isset($test->id))
{!! Form::open(['method' => 'post' , 'id' => 'questions_in_tests_form']) !!}
@include('questions_in_tests.form')
{!! Form::close() !!}
@endif
@endsection