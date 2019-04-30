@extends('layouts.app')

@section('body')
    @php(LinkButton::build("facebook", "redirect", "fab fa-facebook"))
    <hr>
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
        {!! csrf_field() !!}
        @php(Field::build("email", "email"))
        @php(Field::build("password", "password"))
        @php(Field::build("remember", "checkbox", null, false))
        @php(Submit::build("fa fa-btn fa-sign-in"))
    </form>
    <hr>
    @php(LinkButton::build("forgot", "/password/reset"))
@endsection
