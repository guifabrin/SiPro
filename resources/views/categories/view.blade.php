@extends("home")

@section("header")
	{{ _v("mines_gender_a") }} {{ _v("question_categories") }}
@endsection

@section("btn-left")
	<a class="btn btn-primary" href="{{ url("/") }}">
		<i class="fa fa-btn fa-arrow-circle-left"></i> {{ _v("back") }}
	</a>
@endsection

@section("btn-right")
	<a class="btn btn-success" href="{{ url("/".$type."Category/create/") }}">
		<i class="fa fa-plus"></i> {{ _v("add") }}
	</a>
@endsection

@section("body")
    <h3>{{_v($type)}}</h3>
	<ul class="tree">
		<li>
			<div class="dropdown">
				<button class="btn btn-sm btn-secondary dropdown-toggle" id="siproDrodownMenu0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-folder-open"></i>
					{{ _v("categorie.none") }}
					<span class="badge badge-light">{{ Auth::user()->itens($type)->withoutCategorie()->count() }}</span>
				</button>
				<div class="dropdown-menu" aria-labelledby="siproDrodownMenu0">
					<a class="dropdown-item" href="{{ url("/".$type."/itensWithoutCategory") }}">
						<i class="fa fa-eye"></i> {{ _v("see") }}
					</a>
					<a class="dropdown-item" href="{{ url("/".$type."/create") }}">
						<i class="fa fa-plus"></i> {{ _v("add") }}
					</a>
				</div>
			</div>
		</li>
		@include("categories.partials.view", ["categories" => $categories, "manage" => true])
	</ul>
@endsection