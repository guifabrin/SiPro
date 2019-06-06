@extends('layouts.app')

@section('title', __('lang.mines_gender_female')." ". (isset($questionCategory) ? '[ '.$questionCategory->description.' ]' : ''))

@section('btn-left')
	<a class="{{config('constants.classes.buttons.back')}}" href="{{ url('question') }}">
		<i class="{{config('constants.classes.icons.back')}}"></i> {{ __('lang.back') }}
	</a>
@endsection

@section('btn-right')
	<a class="{{config('constants.classes.buttons.add')}}"
	   href="{{ url(isset($questionCategory) ? '/questions/itens/'.$questionCategory->id.'/create' : '/question/create') }}">
		<i class="{{config('constants.classes.icons.add')}}"></i> {{ __('lang.add') }}
	</a>
@endsection

@section('body')
	@include('category.tree.view', [
		'manage' => false,
		'type'=>'question',
		'category'=> $questionCategory,
		'categories' => $questionCategories
	])
	<table class="{{config('constants.classes.table')}}">
		<thead class="{{config('constants.classes.thead')}}">
			<tr>
				<th>{{ __('lang.image') }}</th>
				<th>{{ __('lang.description') }}</th>
				<th>{{ __('lang.actions') }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($questions as $question)
				<tr>
					<td>
						<img src="{{ $question->thumbImage() }}" class="sipro-image-file-select"
							onerror="this.style.display='none'" alt="{{ $question->description }}"/>
					</td>
					<td>{{ $question->description }}</td>
					<td>
						<a class="{{config('constants.classes.buttons.remove')}}" href="{{ url('/question/'.$question->id) }}">
							<i class='{{config('constants.classes.icons.remove')}}'></i> {{ __('lang.remove') }}
						</a>
						<a class="{{config('constants.classes.buttons.edit')}}" href="{{ url('/question/'.$question->id."/edit") }}">
							<i class='{{config('constants.classes.icons.edit')}}'></i> {{ __('lang.edit') }}
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection