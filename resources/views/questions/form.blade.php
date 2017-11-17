@extends('home')

@section('btn-left')
	<a class="btn btn-primary" href="{{ url('questions') }}">
		<i class="fa fa-btn fa-arrow-circle-left"></i> {{ __('lang.back') }}
	</a>
@endsection

@section('header')
	{{ $title }} Questão  {{ isset($categorie) ? '[ '.$categorie->description.' ]' : ''}}
@endsection

@section('body')
	{!! Form::open( array('url' => '/questions'. (isset($question) ? '/'.$question->id : '') , 'method' =>  (isset($question)) ? 'PATCH' : 'POST', 'enctype' => 'multipart/form-data') ) !!}

		<fieldset class="form-group">
    	    <label class="col-md-2 control-label">{{ __('lang.code') }}:</label>
    	    <div class="col-md-10">
    	        <input type="text" class="form-control" readonly="true" value="{{ (isset($question)) ? $question->id : null }}">
    	    </div>
		</fieldset>

		<fieldset class="form-group">
    	    <label class="col-md-2 control-label">{{ __('lang.test_categorie') }}:</label>
	    	    <div class="col-md-10">
		    	    @if (isset($categorie))
		    	    	<input type="hidden" name="categorie_id" value="{{ $categorie->id }}"/>
		    	    	<input type="text" readonly="true" class="form-control" value="{{ $categorie->id }} - {{ $categorie->description }}" />
		    	    @else
		    	    	@if (count($categories) == 0)
		    	    	<input type="hidden" name="categorie_id" value="null"/>
							<div class="alert alert-warning">{{ __('lang.no_one_categorie') }}</div>
		    	    	@else
			    	        <select class="form-control" name="categorie_id">
			    	        	<option value="null" {{ ($categorie==null)?'checked':'' }}>Nenhuma</option>
								@include('questions.categories.partials.option', ['id' => ($categorie==null) ? null : $categorie->id, 'fatherId' => null, 'categories' => $categories, 'nivel' => 0 ])
			    	        </select>
		    	        @endif
		    	    @endif
	    	    </div>
		</fieldset>

		<fieldset class="form-group">
    	    <label class="col-md-2 control-label">{{ __('lang.description') }}:</label>
    	    <div class="col-md-10">
				<textarea class='form-control' name="description">@if(isset($question)){{$question->description}}@endif</textarea>
    	    </div>
		</fieldset>

		<fieldset class="form-group">
    	    <label class="col-md-2 control-label">{{ __('lang.image') }}:</label>
    	    <div class="col-md-10" style="text-align: center;">
    	    	<?php $settedImage = isset($question) && isset($question->image) && isset($question->image->imageb64_thumb);?>
    	        <img class="img-rounded" id="image" style="max-width: 100px; max-height: 100px; margin-bottom: 5px; display: {{$settedImage?'':'none'}};" src="{{$settedImage?$question->image->imageb64_thumb:url('/assets/images/no_image.png')}}"/>
  				<label class="btn btn-success btn-file">
					<i class="fa fa-file"></i>
					<input type="file" name="image" rendererOn="image" accept="image/x-png,image/gif,image/jpeg" />
				</label>
    	    </div>
		</fieldset>

		<fieldset class="form-group">
    	    <label class="col-md-2 control-label">{{ __('lang.type_test') }}:</label>
	    	    <div class="col-md-10">
	    	        <select class="form-control" id="typeCategorie" name="type">
						<option value="0" {{isset($question) && $question->type == 0?'selected':''}}>{{ __('lang.descriptive') }}</option>
						<option value="1" {{isset($question) && $question->type == 1?'selected':''}}>{{ __('lang.optative') }}</option>
						<option value="2" {{isset($question) && $question->type == 2?'selected':''}}>{{ __('lang.true_false') }}</option>
	    	        </select>
	    	    </div>
		</fieldset>

		<fieldset class="form-group" id="lines">
    	    <label class="col-md-2 control-label">{{ __('lang.lines') }}:</label>
    	    <div class="col-md-10">
    	        <input class="form-control" type="number" value="{{isset($question) ? $question->lines : -1 }}" name="lines" />
    	    </div>
		</fieldset>

		<fieldset class="form-group" id="options" style="display: none;">
    	    <label class="col-md-2 control-label">{{ __('lang.options') }}:</label>
    	    <div class="col-md-10">
    	    	<table class="table">
					<thead>
					    <tr>
					    	<th style="width:100px;">{{ __('lang.right') }}</th>
					    	<th style="width:100px;">{{ __('lang.image') }}</th>
					    	<th>Descrição</th>
					    </tr>
					</thead>
					<tbody>
						@for ($i=0; $i<5; $i++)
    	    				<?php $settedOptionImage = isset($options[$i]) && isset($options[$i]->image) && isset($options[$i]->image->imageb64_thumb);?>
						    <tr>
				      			<td>
		    	       				<input type="hidden" value="{{isset($options) && isset($options[$i]) ? $options[$i]->id : 0 }}" name="option-id[{{$i}}]" />
		    	       				<input class="form-control" type="checkbox" value="{{ $i }}" name="option-correct[]" {{ (isset($options) && isset($options[$i]) && $options[$i]->correct)?'checked':'' }}/>
		    	       			</td>
				      			<td style="text-align: center;">
				      				<img class="img-rounded" id="option-image-{{ $i }}" style="max-width: 100px; max-height: 100px; margin-bottom: 5px; display: {{$settedOptionImage?'':'none'}};" src="{{ $settedOptionImage ? $options[$i]->image->imageb64_thumb : url('/assets/images/no_image.png')}}""/>
				      				<label class="btn btn-success btn-file">
	    	       						<i class="fa fa-file"></i>
	    	       						<input type="file" name="option-image[{{ $i }}]" rendererOn="option-image-{{ $i }}" accept="image/x-png,image/gif,image/jpeg" />
									</label>
		    	       			</td>
				      			<td>
									<textarea class='form-control' name="option-description[{{ $i }}]">@if(isset($options) && isset($options[$i])){{$options[$i]->description}}@endif</textarea>
		    	       			</td>
						    </tr>
					    @endfor
				    </tbody>
				</table>
    	    </div>
        </fieldset>

		<fieldset class="form-group">
    	    <div class="col-md-12">
	    		<button type="submit" class="btn btn-success">
	    		    <i class="fa fa-floppy-o"></i> {{ __('lang.save') }}
	    		</button>
	    	</div>
        </fieldset>

		<script>
			$(function (){
				$('#typeCategorie').change(function(){
					switch ($(this).val()*1){
						case 0:
							$('#lines').css('display','');
							$('#options').css('display','none');
						break;
						case 1:
							$('#lines').css('display','none');
							$('#options').css('display','');
							$('#options').find('input[type=checkbox]').attr('type','radio');
						break;
						case 2:
							$('#lines').css('display','none');
							$('#options').css('display','');
							$('#options').find('input[type=radio]').attr('type','checkbox');
						break;
					}
				});
				$('#typeCategorie').change();
			});
		</script>

	{!! Form::close() !!}
@endsection