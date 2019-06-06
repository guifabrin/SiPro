@extends('layouts.app')

@section('title', __('lang.mines_gender_male')." ". (isset($testCategory) ? '[ '.$testCategory->description.' ]' : ''))

@section('btn-left')
	<a class="{{config('constants.classes.buttons.back')}}" href="{{ url('test') }}">
		<i class="{{config('constants.classes.icons.back')}}"></i> {{ __('lang.back') }}
	</a>
@endsection

@section('btn-right')
	<a class="{{config('constants.classes.buttons.add')}}"
	   href="{{ url(isset($testCategory) ? '/tests/itens/'.$testCategory->id.'/create' : '/test/create') }}">
		<i class="{{config('constants.classes.icons.add')}}"></i> {{ __('lang.add') }}
	</a>
@endsection

@section('body')
	@include('category.tree.view', [
		'manage' => false,
		'type'=>'test',
		'category'=> $testCategory,
		'categories' => $testCategories
	])
	<table class="{{config('constants.classes.table')}}">
		<thead class="{{config('constants.classes.thead')}}">
		<tr>
			<th>{{ __('lang.description') }}</th>
			<th>{{ __('lang.actions') }}</th>
		</tr>
		</thead>
		<tbody>
		@foreach ($tests as $test)
			<tr>
				<td>{{ $test->description }}</td>
				<td>
					<a class="{{config('constants.classes.buttons.remove')}}" href="{{ url('/test/'.$test->id) }}">
						<i class='{{config('constants.classes.icons.remove')}}'></i> {{ __('lang.remove') }}
					</a>
					<a class="{{config('constants.classes.buttons.edit')}}" href="{{ url('/test/'.$test->id."/edit") }}">
						<i class='{{config('constants.classes.icons.edit')}}'></i> {{ __('lang.edit') }}
					</a>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@endsection