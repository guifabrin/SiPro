@extends('home')

@section('questions_active') active @endsection

@section('headerbtnl')
	<a class="btn btn-sm btn-primary" href="{{ url('questions') }}">
		<i class="fa fa-btn fa-arrow-circle-left"></i> Voltar
	</a>
@endsection

@section('header')
	{{ $title }} Questão  {{ isset($categorie) ? '[ Categoria: '.$categorie->description.' ]' : ''}}
@endsection

@section('body')
	{!! Form::open( array('url' => '/questions'. (isset($question) ? '/'.$question->id : '') , 'method' =>  (isset($question)) ? 'PATCH' : 'POST', 'enctype' => 'multipart/form-data') ) !!}

		<fieldset class="form-group">
    	    <label class="col-md-4 control-label">Código:</label>
    	    <div class="col-md-8">
    	        <input type="text" class="form-control" readonly="true" value="{{ (isset($question)) ? $question->id : null }}">
    	    </div>
		</fieldset>

		<fieldset class="form-group">
    	    <label class="col-md-4 control-label">Categoria:</label>
	    	    <div class="col-md-8">
		    	    @if (isset($categorie))
			    	    	<input type="hidden" name="categorie_id" value="{{ $categorie->id }}"/>
			    	    	<input type="text" readonly="true" class="form-control" value="{{ $categorie->id }} - {{ $categorie->description }}" />
		    	    @else
			    	    	@if (count($categories) == 0)
			    	    	<input type="hidden" name="categorie_id" value="null"/>
								<div class="alert alert-warning">Nenhuma categoria de questão cadastrada.</div>
			    	    	@else
				    	        <select class="form-control" name="categorie_id">
									@include('questions.categories.partials.option', ['id' => null , 'fatherId' => null, 'categories' => $categories, 'nivel' => 0 ])
				    	        </select>
			    	        @endif
		    	    @endif
	    	    </div>
		</fieldset>

		<fieldset class="form-group">
    	    <label class="col-md-4 control-label">Descrição:</label>
    	    <div class="col-md-8">
				<textarea class='form-control' name="description"></textarea>
    	    </div>
		</fieldset>

		<fieldset class="form-group">
    	    <label class="col-md-4 control-label">Categoria:</label>
	    	    <div class="col-md-8">
	    	        <select class="form-control" id="typeCategorie" name="type">
						<option value="0">Descritiva</option>
						<option value="1">Optativa</option>
						<option value="2">Verdadeiro ou Falso</option>
	    	        </select>
	    	    </div>
		</fieldset>

		<fieldset class="form-group" id="lines">
    	    <label class="col-md-4 control-label">Linhas:</label>
    	    <div class="col-md-8">
    	        <input class="form-control" type="number" value="0" name="lines" />
    	    </div>
		</fieldset>

		<fieldset class="form-group">
    	    <label class="col-md-4 control-label">Imagem:</label>
    	    <div class="col-md-8">
    	        <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg" />
    	    </div>
		</fieldset>

		<fieldset class="form-group">
    		<button type="submit" class="btn btn-sm btn-success">
    		    <i class="fa fa-floppy-o"></i> Salvar
    		</button>
        </fieldset>

		<script>
			$(function (){
				$('#typeCategorie').change(function(){
					switch ($(this).val()*1){
						case 0:
							$('#lines').css('display','');
						break;
						case 1:
						case 2:
							$('#lines').css('display','none');
						break;
					}
				});
			});
		</script>

	{!! Form::close() !!}
@endsection
