@extends('home')

@section('my_account_active') active @endsection

@section('headerbtnl')
<a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">
<i class="fa fa-btn fa-arrow-circle-left"></i> Voltar
</a> 
@endsection

@section('header')
Minha Conta
@endsection

@section('body')
<ul class="list-group">
    <li class="list-group-item"><a href="{{ url('/user/password') }}"><i class="fa fa-key fa-btn"></i> Alterar senha de acesso</a></li>
</ul>
@endsection