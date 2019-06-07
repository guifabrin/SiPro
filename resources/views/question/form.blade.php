@php
	if (!isset($questionCategory))
		$questionCategory = isset($question) ? $question->category()->first() : null;
@endphp

@extends('layouts.app')

@section('title', ($question->id ? __('lang.edit') : __('lang.add'))." ".__('lang.question'). ($questionCategory ? "[ ".$questionCategory->description." ]" : "") )

@section('btn-left')
	<a class="{{config('constants.classes.buttons.back')}}" href="{{ url('question') }}">
		<i class="{{config('constants.classes.icons.back')}}"></i> {{ __('lang.back') }}
	</a>
@endsection

@section('body')
	<form action="{{ url('/question/'.$question->id) }}" method="POST" enctype="multipart/form-data">
		@csrf
		@if (isset($question->id))
			@method("PUT")
		@endif
		<div class="form-group">
			<label for="idText">{{__('lang.id')}}</label>
			<input type="text" name="id" id="idText" value="{{old('id', $test->id)}}" class="form-control" placeholder="{{__('lang.id_placeholder')}}" readonly="true">
		</div>
		<div class="form-group">
			<label for="category_id">{{ __('lang.questions.form.category_id') }}:</label>
			@include('category.tree.select', [
				'father' => false,
				'type'=> 'question',
				'key' => 'category_id',
				'category' => $questionCategory,
				'categories' => $questionCategories
			])
		</div>
		<div class="form-group">
			<label for="descriptionText">{{__('lang.description')}}</label>
			<textarea name="description" id="descriptionText"
				class="form-control" required="true">{{old('description', $question->description)}}</textarea>
		</div>
		<input type="file" name="image_id" class="form-control">
		<select name="type" id="typeSelect" class="form-control">
			<option value="0" {{!$question->type || $question->type==0?"selected=true":""}}>{{__('lang.questions.form.descriptive')}}</option>
			<option value="1" {{$question->type==1?"selected=true":""}}>{{__('lang.questions.form.optative')}}</option>
			<option value="2" {{$question->type==2?"selected=true":""}}>{{__('lang.questions.form.true_false')}}</option>
		</select>
		<input type="number" name="lines" id="linesNumber" class="form-control" value="{{$question->id ? $question->lines : -1}}">
		<div class="form-group" id="options" style="display: none;">
			<label>{{ __('lang.options') }}:</label>
			<table class="{{config('constants.classes.table')}}">
				<thead class="{{config('constants.classes.thead')}}">
				<tr>
					<th>{{ __('lang.right') }}</th>
					<th>{{ __('lang.image') }}</th>
					<th>{{ __('lang.description') }}</th>
				</tr>
				</thead>
				<tbody>
					@for ($i=0; $i<5; $i++)
						@php
							$settedOption = isset($question->options) && isset( $question->options[$i]);
						@endphp
						<tr>
							<td>
								<input type="hidden" name="option-id[{{$i}}]">
								<input type="checkbox" name="option-correct[]" value="{{$i}}"
									{{$settedOption &&  $question->options[$i]->correct ? "checked=true" : ""}}
								>
							</td>
							<td>
								<input type="file" name="option-image[{{$i}}]">
							</td>
							<td>
								<textarea name="option-description[{{$i}}]" id="option-description[{{$i}}]Text"
									class="form-control" required="true">{{
										old(
											'option-description['.$i.']',
											$settedOption ?  $question->options[$i]->description : ""
										)
									}}</textarea>
							</td>
						</tr>
					@endfor
				</tbody>
			</table>
		</div>
		<button class="{{config('constants.classes.buttons.submit')}}">
			<i class="{{config('constants.classes.icons.submit')}}"></i>
			{{__('lang.submit')}}
		</button>
		<script type="text/javascript" src="{{ URL::asset('js/questions/form.js') }}"></script>
	</form>
@endsection