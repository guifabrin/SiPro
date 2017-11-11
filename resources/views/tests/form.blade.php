@extends('home')

@section('tests_active') active @endsection

@section('headerbtnl')
	<a class="btn btn-sm btn-primary" href="{{ url('tests') }}">
		<i class="fa fa-arrow-circle-left"></i> Voltar
	</a>
@endsection

@section('header')
	{{ $title }} Prova
@endsection

@section('body')
{!! Form::open( array('url' => '/tests'. (isset($test) ? '/'.$test->id : '') , 'method' =>  (isset($test)) ? 'PATCH' : 'POST', 'enctype' => 'multipart/form-data') ) !!}

		<fieldset class="form-group">
    	    <label class="col-md-2 control-label">Código:</label>
    	    <div class="col-md-10">
    	        <input type="text" class="form-control" readonly="true" value="{{ (isset($test)) ? $test->id : null }}">
    	    </div>
		</fieldset>

		<fieldset class="form-group">
    	    <label class="col-md-2 control-label">Categoria:</label>
	    	    <div class="col-md-10">
		    	    @if (isset($categorie))
		    	    	<input type="hidden" name="categorie_id" value="{{ $categorie->id }}"/>
		    	    	<input type="text" readonly="true" class="form-control" value="{{ $categorie->id }} - {{ $categorie->description }}" />
		    	    @else
		    	    	@if (count($categories) == 0)
		    	    	<input type="hidden" name="categorie_id" value="null"/>
							<div class="alert alert-warning">Nenhuma categoria de teste cadastrada.</div>
		    	    	@else
			    	        <select class="form-control" name="categorie_id">
			    	        	<option value="null" {{ ($categorie==null)?'checked':'' }}>Nenhuma</option>
								@include('tests.categories.partials.option', ['id' => ($categorie==null) ? null : $categorie->id, 'fatherId' => null, 'categories' => $categories, 'nivel' => 0 ])
			    	        </select>
		    	        @endif
		    	    @endif
	    	    </div>
		</fieldset>

		<fieldset class="form-group">
    	    <label class="col-md-2 control-label">Descrição:</label>
    	    <div class="col-md-10">
				<textarea class='form-control' name="description">@if(isset($test)){{$test->description}}@endif</textarea>
    	    </div>
		</fieldset>

		<fieldset class="form-group">
    	    <div class="col-md-12">
	    		<button type="submit" class="btn btn-sm btn-success">
	    		    <i class="fa fa-floppy-o"></i> Salvar
	    		</button>
	    	</div>
        </fieldset>
	{!! Form::close() !!}
@endsection