@extends("layouts.app")

@section("btn-left")
    <a class="btn   btn-primary" href="{{ url($type."Category") }}">
        <i class="fa fa-arrow-circle-left"></i> {{ _v("back") }}
    </a>
@endsection

@section("body")
    <form method="POST" action="{{url($type."Category/".$category->id) }}">
        @csrf
        @method("DELETE")
        <div class="alert alert-warning">
            {{ _v("remove_message") }} "{{$category->description}}"?
        </div>

        <p class="yes-no-buttons">
            <button type="submit" class="btn btn-info">
                <i class="fa fa-thumbs-up"></i> {{ _v("yes") }}
            </button>
            <a class="btn btn-info" href="{{ url($type."Category/") }}">
                <i class="fa fa-thumbs-down"></i> {{ _v("no") }}
            </a>
        </p>

    </form>
@endsection