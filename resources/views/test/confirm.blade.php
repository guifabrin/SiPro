@extends('home')

@section('btn-left')
    <a class="btn btn-primary" href="{{ url('test') }}">
        <i class="fa fa-arrow-circle-left"></i> {{ _v('back') }}
    </a>
@endsection

@section('body')
    <form method="POST" action="{{url("test/".$test->id) }}">
        @csrf
        @method("DELETE")
        <div class="alert alert-warning">
            {{ _v("remove_test_message") }} "{{$test->description}}"?
        </div>

        <p class="yes-no-buttons">
            <button type="submit" class="btn btn-info">
                <i class="fa fa-thumbs-up"></i> {{ _v("yes") }}
            </button>
            <a class="btn btn-info" href="{{ url("test/") }}">
                <i class="fa fa-thumbs-down"></i> {{ _v("no") }}
            </a>
        </p>

    </form>
@endsection