@extends('layouts.app')

@section('btn-left')
    <a class="btn btn-primary" href="{{ url('/') }}">
        <i class="fa fa-btn fa-arrow-circle-left"></i> {{ _v('back') }}
    </a>
@endsection

@section('header')
    {{ _v($isSocialAccount?'create_password':'edit_password') }}
@endsection

@section('body')

    <form action="{{url("user/".Auth::user()->id)}}" method="POST">
        @method('PUT')
        @csrf
        @if (!$isSocialAccount)
            @php(Field::build('old-password', 'password'))
        @endif
        @php(Field::build('password', 'password'))
        @php(Field::build('new-password', 'password'))
        @php(Submit::build('fa fa-save'))
    </form>
@endsection