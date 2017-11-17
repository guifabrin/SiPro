@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
        @if (Auth::check())
            <div class="col-xs-12 col-sm-12 col-md-3 panel">
                <div class="head">
                    <h2>{{ __('lang.sidebar') }}</h2>
                </div>
                <div class="body sidebar">
                    @include('sidebar')
                </div>
            </div>
            <div class="col-md-9 panel">
        @else
            <div class="col-xs-12 col-md-12 panel">
        @endif
                <div class="head">
                    <div class="btn-left">@yield('btn-left')</div>
                    <h2>@yield('header')</h2>
                    <div class="btn-right">@yield('btn-right') </div>
                </div>
                <div class="body">
                    @if (Auth::check() && (!isset(Auth::user()->password) || Auth::user()->password==""))
                        <div class="alert alert-warning">{{__('lang.empty_password')}}</div>
                        <a class="btn btn-warning" href="{{ url('/user/password') }}" title="{{ __('lang.create_password') }}">{{ __('lang.create_password') }}</a>
                    @endif
                    @if (isset($message) && count($message)>0)
                        <div class="alert alert-{{$message['status']}}">{{$message['message']}}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @yield('body')
                </div>
            </div>
        </div>
    </div>
@endsection