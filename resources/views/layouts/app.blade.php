<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta property="og:url" content="{{ url('/') }}" />
  <meta property="og:title" content="{{ __('lang.title')}}" />
  <meta property="og:type" content="article" />
  <meta property="og:image" content="{{ url('/assets/images/facebookshare.png') }}">
  <meta property="fb:app_id" content="1168613666495068" />
  <meta name="csrf-token" content="{{ Session::token() }}">
  <title>{{  __('lang.title') }}</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ url('assets/css/app.css') }}">
  <link rel="icon" type="image/png" href="{{ url('/assets/images/logo.ico') }}" />
</head>

<body id="app-layout">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <header>
    <h1>{{  __('lang.title') }} | @yield('header')</h1>
  </header>
  <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ url('/') }}"> <img src="{{ url('/assets/images/logo.png') }}" /> Si<font color="#800000"><b>PRO</b></font>
    </a>
    <?php
$rtUrl = Request::url();
$current = "<span class='sr-only'>(current)</span>";
?>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item {{ $rtUrl == url('/') || $rtUrl == url('/logout') ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('/') }}">{{  __('lang.home') }} {!! $rtUrl == url('/') || $rtUrl == url('/logout') ? $current : '' !!}</a>
        </li>
        <li class="nav-item {{ $rtUrl == url('/policy') ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('/policy') }}">{{  __('lang.policy') }} {!! $rtUrl == url('/policy') ? $current : '' !!}</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        @if (!Auth::guest())
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> {{ __('lang.logoff') }}</a>
          </div>
        </li>
        @else
        <li class="nav-item {{ $rtUrl == url('/login') ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('/login') }}">{{ __('lang.login') }} {!! $rtUrl == url('/login') ? $current : '' !!}</a>
        </li>
        <li class="nav-item {{ $rtUrl == url('/register') ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('/register') }}">{{  __('lang.register') }} {!! $rtUrl == url('/register') ? $current : '' !!}</a>
        </li>
        @endif
      </ul>
    </div>
  </nav>
  <section>
    @yield('content')
  </section>
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-12 panel">
           {{ __('lang.developed_by') }} <a href="mailto:guilherme.fabrin@gmail.com">Guilherme Fabrin Franco</a> © - {{ __('lang.rights') }} {{ date('Y') }}.
          <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">
            <img alt="Licença Creative Commons" src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" />
          </a>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <script>
    (function(i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r;
      i[r] = i[r] || function() {
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
  <script src="{{ url('assets/js/app.js') }}"></script>
</body>

</html>