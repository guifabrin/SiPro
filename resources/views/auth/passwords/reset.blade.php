@extends('home')

@section('body')
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
        {!! csrf_field() !!}
        @php(Field::build("email", "email"))
        @php(Field::build("password", "password"))
        @php(Field::build("password_confirmation", "password"))
        @php(Field::build("token", "hidden", $token))
        @php(Submit::build("fa fa-btn fa-refresh"))
    </form>
@endsection
