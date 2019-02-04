@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Auth::check())
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
            @include('bar')
            </div>
        </div>
        @endif

            <div class="row buttons">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="float-left">@yield('btn-left')</div>
                <div class="float-right">@yield('btn-right') </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-12">
                @if (Auth::check() && (!isset(Auth::user()->password) || Auth::user()->password==""))
                    <div class="alert alert-warning">{{__('lang.empty_password')}}</div>
                    <a class="btn btn-warning" href="{{ url('/user/password') }}" title="{{ __('lang.create_password') }}">
                        {{ __('lang.create_password') }}
                    </a>
                @endif
                @php(App\Helpers\Boostrap\Alert::echo())
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
@endsection