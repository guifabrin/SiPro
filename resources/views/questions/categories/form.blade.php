@extends('home')

@section('btn-left')
	<a class="btn   btn-primary" href="{{ url('/questions/categories') }}">
		<i class="fa fa-arrow-circle-left"></i> {{ __('lang.back') }}
	</a>
@endsection

@section('header')
	{{ $title }} {{ __('lang.question_categorie') }}
@endsection

@section('body')
	{!! Form::open( array('url' => '/questions/categories'. (isset($categorie) ? '/'.$categorie->id : '') , 'method' =>  (isset($categorie)) ? 'PATCH' : 'POST') ) !!}

		{{ csrf_field() }}
		<fieldset class="form-group">
    	    <label class="col-md-4 control-label">{{ __('lang.code') }}:</label>
    	    <div class="col-md-6">
    	        <input type="text" class="form-control" readonly="true" value="{{ (isset($categorie)) ? $categorie->id : null }}">
    	    </div>
    	</fieldset>

    	<fieldset class="form-group">
    	    <label class="col-md-4 control-label">{{ __('lang.father_categorie') }}:</label>
    	    <div class="col-md-6">
    	    	@if (count($categories) == 0)
					<div class="alert alert-warning">{{ __('lang.no_one_categorie') }}</div>
    	    	@else
	    	        <select class="form-control" name="father_id">
						@include('questions.categories.partials.option', ['id' => (isset($categorie))?$categorie->id:null, 'fatherId' => (isset($categorie))?$categorie->father_id:null, 'categories' => $categories, 'nivel' => 0 ])
	    	        </select>
    	        @endif
    	    </div>
    	</fieldset>

		<fieldset class="form-group">
    	    <label class="col-md-4 control-label">{{ __('lang.description') }}:</label>
    	    <div class="col-md-6">
    	        <input type="text" class="form-control" name="description" value="{{ (isset($categorie)) ? $categorie->description : null }}" placeholder="Matemática" required="true">
    	    </div>
    	</fieldset>

        <fieldset class="form-group">
    		<button type="submit" class="btn btn-success">
    		    <i class="fa fa-floppy-o"></i> {{ __('lang.save') }}
    		</button>
        </fieldset>

	{!! Form::close() !!}
@endsection