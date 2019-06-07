@extends("layouts.app")

@section("title", __('lang.category.confirm.title', ['name' => __('lang.'.$type)]))

@section("btn-left")
<a class="{{config('constants.classes.buttons.back')}}" href="{{ url($type."Category") }}">
	<i class="{{config('constants.classes.icons.back')}}"></i> {{ __("lang.back") }}
</a>
@endsection

@section("body")
<form method="POST" action="{{url($type."Category/".$category->id) }}">
	@csrf
	@method("DELETE")
	<div class="alert alert-warning">
		{{ __("lang.category.confirm.message") }}"{{$category->description}}"?
	</div>
	<p class="yes-no-buttons">
		<button class="{{config('constants.classes.buttons.yes')}}">
			<i class="{{config('constants.classes.icons.yes')}}"></i> {{ __("lang.yes") }}
		</button>
		<a class="{{config('constants.classes.buttons.no')}}" href="{{ url($type."Category/") }}">
			<i class="{{config('constants.classes.icons.no')}}"></i> {{ __("lang.no") }}
		</a>
	</p>
</form>
@endsection