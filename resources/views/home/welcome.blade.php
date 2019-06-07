@extends('layouts.app')

@section('body')
    <img class="welcome-logo" src="{{ asset('/images/logo.png') }}" alt="{{ __('lang.welcome.title') }}">
    <hr>
    {!! __('lang.welcome.message') !!}
    <hr>
    {!! __('lang.welcome.description') !!}
    <hr>
    {!! __('lang.welcome.thanks') !!}
    <a href="mailto:guilherme.fabrin@gmail.com">Guilherme Fabrin Franco</a>
@endsection