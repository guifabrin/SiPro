@extends('layouts.app')

@section('btn-left')
    <a class="btn btn-primary" href="{{ url('question') }}">
        <i class="fa fa-btn fa-arrow-circle-left"></i> {{ _v('back') }}
    </a>
@endsection

@section('body')
    <form method="POST" action="{{url("question/".$question->id) }}">
        @csrf
        @method("DELETE")
        <div class="alert alert-warning">
            {{ _v("remove_question_message") }} "{{$question->description}}"?
        </div>

        <p class="yes-no-buttons">
            <button type="submit" class="btn btn-info">
                <i class="fa fa-thumbs-up"></i> {{ _v("yes") }}
            </button>
            <a class="btn btn-info" href="{{ url("question/") }}">
                <i class="fa fa-thumbs-down"></i> {{ _v("no") }}
            </a>
        </p>

    </form>
@endsection