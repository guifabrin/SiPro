@php
    $action = _v($category->id ? 'edit' : 'new');
    $name = _v($type);
@endphp
@extends("layouts.app")

@section("btn-left")
    <a class="btn btn-primary" href="{{ url("/".$type."Category") }}">
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
        @include("category.tree.select", [
            "father" => true,
            "key" => "father_id",
            "category" => $category,
            "categories" => $categories,
        ])
        @php(Field::build("description", "text", $category->description))
        @php(Submit::build("fa fa-save"))
    </form>
@endsection