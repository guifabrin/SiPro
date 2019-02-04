<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title>{{  __('app.title') }}</title>

  @include('layouts.meta.basic')
  @include('layouts.meta.social')

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="icon" href="{{ asset('images/logo.ico') }}" />
</head>

<body id="app-layout">
  <header class="container text-center">
    <h1>{{ __('app.title') }}</h1>
    <h2>{{ _v('title') }}</h2>
  </header>

  @include('layouts.partials.nav')

  <section>
    @yield('content')
  </section>

  <footer>
    <div class="container">
      <div class="row">
        <div class="col-12 panel">
           {{ __('app.developed_by') }} <a href="mailto:guilherme.fabrin@gmail.com">Guilherme Fabrin Franco</a> © - {{ __('app.rights') }} {{ date('Y') }}.
          <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">
            <img alt="{{__('app.license')}}" src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" />
          </a>
        </div>
      </div>
    </div>
  </footer>

  @include('layouts.script.google')

  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>