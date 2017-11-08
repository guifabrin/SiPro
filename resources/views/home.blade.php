@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="row">
    @if (Auth::check())
        <div class="col-xs-12 col-sm-12 col-md-3 sidebar">
            <div class="panel">
                <div class="panel-heading">
                    <h2>Menu Lateral</h2>
                </div>
                <div class="panel-body">
                    @include('sidebar')
                </div>
            </div>
        </div>
        <div class="col-md-9 bodycontent">
        @else
        <div class="col-xs-12 col-md-12">
        @endif
            <div class="panel">
                <div class="panel-heading">
                    <div class="btnl">@yield('headerbtnl')</div>
                    <h2>@yield('header')</h2>
                    <div class="btnr">@yield('headerbtnr') </div>
                </div>
                <div class="panel-body">
                @if (Auth::check())
                    @if (!isset(Auth::user()->password) || Auth::user()->password=="")
                        <div id="password_empty" class="alert alert-warning" role="alert"><p><b>Atenção:</b> como você registrou-se no sistema com uma conta do Facebook é necessário que você crie uma senha para o sistema.</p><center><a class="btn btn-sm btn-warning" href="{{ url('/user/password') }}" title="Criar senha">Criar senha</a></center></div>
                    @endif
                @endif
                    @if (isset($message) && count($message)>0)
                        <div class="alert alert-{{$message['status']}}">{{$message['message']}}</div>
                    @endif
                    @yield('body')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection