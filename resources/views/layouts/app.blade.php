<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta property="og:url" content="{{ url('/') }}"/>
  <meta property="og:title" content="SiPRO - Sistema de Provas"/>
  <meta property="og:type" content="article" />
  <meta property="og:image" content="{{ url('/assets/images/facebookshare.png') }}">
  <meta property="fb:app_id" content="1168613666495068" />

  <title>SiPRO</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ url('assets/css/app.css') }}">
  <link rel="icon" type="image/png" href="{{ url('/assets/images/logo.ico') }}" />
</head>
<body id="app-layout">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

  <header>
    <h1>SiPRO - Sistema de Provas | @yield('header')</h1>
  </header>

  <nav class="navbar navbar-light bg-faded">
    <div class="container">
    <h2>Barra de Navegação</h2>
    <div class="custom-nav">
      <a class="navbar-brand" href="{{ url('/') }}"> <img src="{{ url('/assets/images/logo.png') }}"/> Si<font color="#800000"><b>PRO</b></font></a>
      <button class="navbar-toggler hidden-sm-up pull-right" type="button" data-toggle="collapse" data-target="#navBar">
        &#9776;
      </button>
    </div>
    <div class="collapse navbar-toggleable-xs" id="navBar">
      <ul class="nav navbar-nav">
      @if (!Auth::guest())
        <li class="nav-item"><a class="nav-link" href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Sair</a></li>
      @else
        <li  class="nav-item"><a  class="nav-link" href="{{ url('/login') }}">Entrar</a></li>
        <li  class="nav-item "><a  class="nav-link" href="{{ url('/register') }}">Registrar</a></li>
      @endif
      </ul>
      </div>
    </div>
  </nav>

  <section>
    @yield('content')
  </section>

  <footer>
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="panel">
              <div class="panel-body">
                  Desenvolvido por <a href="mailto:guilherme.fabrin@gmail.com"> Guilherme Fabrin Franco</a> © - Direitos Reservados 2016.
                  <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">

                  <img alt="Licença Creative Commons" src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" /></a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-81128126-1', 'auto');
    ga('send', 'pageview');

  </script>
  <script src="{{ url('assets/js/app.js') }}"></script>

</body>
</html>