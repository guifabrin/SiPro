<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>{{  __('app.title') }}</title>

    @include('layouts.meta.basic')
    @include('layouts.meta.social')

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" href="{{ asset('images/logo.ico') }}"/>
</head>

<body id="app-layout">
@include('layouts.partials.nav')

<section>
    <div class="wrapper">

        @if(Auth::check())
            <nav id="siproNavbarSidebar" class="navbar-dark bg-dark collapse show">
                @include('sidebar')
            </nav>
        @endif

        <div id="siproContent">
            <header class="container text-center">
                <h1>{{ __('app.title') }}</h1>
                @php
                    $titleParams = [
                        'action' => empty($action) ? null : $action,
                        'name' => empty($name) ? null : $name
                    ]
                @endphp
                <h2>{{ _v('title', $titleParams) }}</h2>
            </header>

            <div class="container">
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
                            <a class="btn btn-warning" href="{{ url('/user/password') }}"
                               title="{{ __('lang.create_password') }}">
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
        </div>

    </div>
</section>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-12 panel">
                {{ __('app.developed_by') }} <a href="mailto:guilherme.fabrin@gmail.com">Guilherme Fabrin Franco</a> ©
                - {{ __('app.rights') }} {{ date('Y') }}.
                <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">
                    <img alt="{{__('app.license')}}" src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png"/>
                </a>
            </div>
        </div>
    </div>
</footer>

@include('layouts.script.google')

<script src="{{ asset('js/app.js') }}"></script>
<script>
    @php(App\Helpers\JS::echo())
    @php(App\Helpers\ConsoleJS::echo())
</script>
</body>

</html>