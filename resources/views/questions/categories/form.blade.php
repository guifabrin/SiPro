@extends('home')

@section('categories_questions_active') active @endsection

@section('headerbtnl')
	<a class="btn btn-sm btn-primary" href="{{ url('/questions/categories') }}">
		<i class="fa fa-arrow-circle-left"></i> Voltar
	</a>
@endsection

@section('header')
	{{ $title }} Categoria de Questão
@endsection

@section('body')
	{!! Form::open( array('url' => '/questions/categories'. (isset($categorie) ? '/'.$categorie->id : '') , 'method' =>  (isset($categorie)) ? 'PATCH' : 'POST') ) !!}

		{{ csrf_field() }}
		<fieldset class="form-group">
    	    <label class="col-md-4 control-label">Código:</label>
    	    <div class="col-md-6">
    	        <input type="text" class="form-control" readonly="true" value="{{ (isset($categorie)) ? $categorie->id : null }}">
    	    </div>
    	</fieldset>

    	<fieldset class="form-group">
    	    <label class="col-md-4 control-label">Categoria Pai:</label>
    	    <div class="col-md-6">
    	    	@if (count($categories) == 0)
					<div class="alert alert-warning">Nenhuma categoria de questão cadastrada.</div>
    	    	@else
	    	        <select class="form-control" name="father_id">
						@include('questions.categories.partials.option', ['id' => (isset($categorie))?$categorie->id:null, 'fatherId' => (isset($categorie))?$categorie->father_id:null, 'categories' => $categories, 'nivel' => 0 ])
	    	        </select>
    	        @endif
    	    </div>
    	</fieldset>

		<fieldset class="form-group">
    	    <label class="col-md-4 control-label">Descrição:</label>
    	    <div class="col-md-6">
    	        <input type="text" class="form-control" name="description" value="{{ (isset($categorie)) ? $categorie->description : null }}" placeholder="Matemática" required="true">
    	    </div>
    	</fieldset>

        <fieldset class="form-group">
    		<button type="submit" class="btn btn-sm btn-success">
    		    <i class="fa fa-floppy-o"></i> Salvar
    		</button>
        </fieldset>

	{!! Form::close() !!}
@endsection