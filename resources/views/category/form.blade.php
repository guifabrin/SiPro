@extends("layouts.app")

@section("title", __('lang.category.form.title', [
'action' => $category->id ? __('lang.edit') : __('lang.add'),
'name' => __('lang.'.$type)
]
))

@section("btn-left")
<a class="{{config('constants.classes.buttons.back')}}" href="{{ url("/".$type."Category") }}">
	<i class="{{config('constants.classes.icons.back')}}"></i> {{ __("lang.back") }}
</a>
@endsection

@section("body")
<form action="{{url("/".$type."Category/".$category->id)}}" method="POST">
	@csrf
	@if (isset($category->id))
		@method("PUT")
	@endif
	<div class="form-group">
		<label for="idText">{{__('lang.id')}}</label>
		<input type="text" name="id" id="idText" value="{{old('id', $category->id)}}" class="form-control" placeholder="{{__('lang.id_placeholder')}}" readonly="true">
	</div>
	@include("category.tree.select", [
		"father" => true,
		"key" => "father_id",
		"category" => $category,
		"categories" => $categories,
	])
	<div class="form-group">
		<label for="descriptionText">{{__('lang.description')}}</label>
		<input type="text" name="description" id="descriptionText" value="{{old('id', $category->description)}}" class="form-control" required="true">
	</div>
	<button class="{{config('constants.classes.buttons.submit')}}">
		<i class="{{config('constants.classes.icons.submit')}}"></i>
		{{__('lang.submit')}}
	</button>
</form>
@endsection