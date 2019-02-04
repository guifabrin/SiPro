@extends('home')

@section('body')
    <img class="welcome-logo" src="{{ asset('/images/logo.png') }}">
    <hr>
    {!! _v('message') !!}
    <hr>
    {!! _v('description') !!}
    <hr>
    {!! _v('thanks') !!}
    <a href="mailto:guilherme.fabrin@gmail.com">Guilherme Fabrin Franco</a>
@endsection