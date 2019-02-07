@extends('home')

@section('body')
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
        {!! csrf_field() !!}
        @php(Field::build("email", "email"))
        @php(Submit::build("fa fa-btn fa-sign-in"))
    </form>
@endsection
