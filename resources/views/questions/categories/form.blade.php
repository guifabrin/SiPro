@extends('home')

@section('categories_questions_active') active @endsection

@section('header')
<a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">
<i class="fa fa-arrow-circle-left"></i> Voltar
</a>
@endsection

@section('header')
{{ $title }} Categoria de Questão
@endsection

@section('body')
{!! Form::open(array('method' => 'post')) !!}

<div class="form-group">
    {{ Form::label('id','Código:', ['class' => 'control-label']) }}
    {{ Form::text('id', (isset($question))?$question->id:null, ['class' => 'form-control', 'readonly' => 'true']) }}
</div>
<div class="form-group">
    {{ Form::label('father_id','Categoria Pai:', ['class' => 'control-label']) }}
    <div id="tree"></div>
	<input type="hidden" id="father_id" name="father_id">
</div>
<div class="form-group">
    {{ Form::label('description','Descrição:', ['class' => 'control-label']) }}
    {{ Form::text('description', (isset($question))?$question->description:null, ['class' => 'form-control', 'placeholder' => 'Matemática', 'required' => 'true']) }}
</div>

<button type="submit" class="btn btn-sm btn-success">
    <i class="fa fa-floppy-o"></i> Salvar
</button>
{!! Form::close() !!}

<script src="{{ url('/assets/js/bootstrap-treeview.min.js') }}"></script>
<script src="{{ url('/assets/js/categories.js') }}"></script>
<script>
	$(function(){
		create_tree_categories({
			"show_actions": false,
			"input_result": $("#father_id"),
			"continue_childs": {{(isset($question))?"false":"true"}},
			"update_page": '{{url("/home/questions/categories/update")}}',
			"delete_page": '{{url("/home/questions/categories/delete")}}',
			"selected_id": {{(isset($question))?$question->father_id:"0"}},
			"values":$.parseJSON(("{{ json_encode($categories) }}").replace(/&quot;/g, '\"'))
		});
	});
</script>
@endsection