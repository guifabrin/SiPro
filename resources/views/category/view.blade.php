@extends("layouts.app")

@section("title", __('lang.category.view.title', ['name' => __('lang.'.$type)]))

@section("btn-left")
<a class="{{config('constants.classes.buttons.back')}}" href="{{ url("/") }}">
	<i class="{{config('constants.classes.icons.back')}}"></i> {{ __("lang.back") }}
</a>
@endsection

@section("btn-right")
<a class="{{config('constants.classes.buttons.add')}}" href="{{ url("/".$type."Category/create/") }}">
	<i class="{{config('constants.classes.icons.add')}}"></i> {{ __("lang.add") }}
</a>
@endsection

@section("body")
	@include("category.tree.view", ["type" => $type, "categories" => $categories])
@endsection