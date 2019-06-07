@php
	if (!isset($itemCategory))
		$itemCategory = isset($item) ? $item->category()->first() : null;
@endphp

@extends('layouts.app')

@section('title', ($item->id ? __('lang.edit') : __('lang.add'))." ".__('lang.question') ." ". ($itemCategory ? "[ ".$itemCategory->description." ]" : "") )

@section('btn-left')
	<a class="{{config('constants.classes.buttons.back')}}" href="{{ url('question') }}">
		<i class="{{config('constants.classes.icons.back')}}"></i> {{ __('lang.back') }}
	</a>
@endsection

@section('body')
	<form action="{{ url('/question/'.$item->id) }}" method="POST" enctype="multipart/form-data">
		@csrf
		@if (isset($item->id))
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
				'category' => $itemCategory,
				'categories' => $itemCategories
			])
		</div>
		<div class="form-group">
			<label for="descriptionText">{{__('lang.description')}}</label>
			<textarea name="description" id="descriptionText"
				class="form-control" required="true">{{old('description', $item->description)}}</textarea>
		</div>
		<div class="form-group">
			<label for="imageFile">{{__('lang.image')}}</label>
			@if ($item->image)
				<img class="sipro-image-file-select" onerror="this.style.display='none'" src="{{$item->thumbImage()}}"/>
				<input type="hidden" id="hiddenImage" name="hidden-image" class="form-control" value="{{$item->thumbImage()}}">
			@endif
			<input type="file" id="imageFile" name="image" class="form-control">
		</div>
		<div class="form-group">
			<label for="typeSelect">{{__('lang.questions.form.category_id')}}</label>
			<select name="type" id="typeSelect" class="form-control">
				<option value="0" {{!$item->type || $item->type==0?"selected=true":""}}>{{__('lang.questions.form.descriptive')}}</option>
				<option value="1" {{$item->type==1?"selected=true":""}}>{{__('lang.questions.form.optative')}}</option>
				<option value="2" {{$item->type==2?"selected=true":""}}>{{__('lang.questions.form.true_false')}}</option>
			</select>
		</div>
		<div class="form-group">
			<label for="linesNumber">{{__('lang.questions.form.lines')}}</label>
			<input type="number" name="lines" id="linesNumber" class="form-control" value="{{$item->id ? $item->lines : -1}}">
		</div>
		<div class="form-group" id="options" style="display: none;">
			<label>{{ __('lang.questions.form.options') }}:</label>
			<table class="{{config('constants.classes.table')}}">
				<thead class="{{config('constants.classes.thead')}}">
				<tr>
					<th>{{ __('lang.questions.form.right') }}</th>
					<th>{{ __('lang.image') }}</th>
					<th>{{ __('lang.description') }}</th>
				</tr>
				</thead>
				<tbody>
					@for ($i=0; $i<5; $i++)
						@php
							$settedOption = isset($item->options) && isset( $item->options[$i]);
						@endphp
						<tr>
							<td>
								<input type="hidden" name="option-id[{{$i}}]">
								<input type="checkbox" name="option-correct[]" value="{{$i}}"
									{{$settedOption &&  $item->options[$i]->correct ? "checked=true" : ""}}
								>
							</td>
							<td>
								@if ($item->options[$i]->image)
									<img class="sipro-image-file-select" onerror="this.style.display='none'" src="{{$item->options[$i]->thumbImage()}}"/>
									<input type="hidden" id="optionHiddenImage_{{$i}}" name="option-hidden[{{$i}}]" class="form-control" value="{{$item->thumbImage()}}">
								@endif
								<input type="file" name="option-image[{{$i}}]">
							</td>
							<td>
								<textarea name="option-description[{{$i}}]" id="option-description[{{$i}}]Text"
									class="form-control" required="true">{{
										old(
											'option-description['.$i.']',
											$settedOption ?  $item->options[$i]->description : ""
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