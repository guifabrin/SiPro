<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@yield('content')

<script>
    @php(App\Helpers\ConsoleJS::echo())
</script>
</body>

</html>