@extends("home")

@section("btn-left")
	<a class="btn btn-primary" href="{{ url("/".$type."category") }}">
		<i class="fa fa-arrow-circle-left"></i> {{ _v("back") }}
	</a>
@endsection

@section("body")
	<form action="{{url("/".$type."Category/".$category->id)}}"
		  method="POST">
		@csrf
		@if (isset($category->id))
			@method("PUT")
		@endif
		@php(Field::build("id", "text", $category->id, false, true))
		<ul class="tree">
			<li>
				<input type="radio" name="father_id" style="margin-top: 11pt;" value="null"
					@if ($category->father_id == null)
						checked
					@endif
				/> {{ _v("categorie.none") }}
			</li>
			@include("categories.partials.view", [
				"select" => true,
				"radioKey" => "father_id",
				"categories" => $categories,
				"category" => $category
			])
		</ul>
		@php(Field::build("description", "text", $category->description))
		@php(Submit::build("fa fa-floppy-o"))
	</form>
@endsection