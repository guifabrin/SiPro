<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>{{  __('app.title') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" href="{{ asset('images/logo.ico') }}"/>
</head>

<body id="app-layout">
<section>
    <div class="wrapper">
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

<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-81128126-1', 'auto');
    ga('send', 'pageview');
</script>

<script src="{{ asset('js/app.js') }}"></script>
</body>

</html>