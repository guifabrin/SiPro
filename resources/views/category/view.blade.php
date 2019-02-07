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
    @include("category.tree.view", ["type" => $type, "categories" => $categories])
@endsection