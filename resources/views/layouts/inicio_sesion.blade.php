<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dr. Wilson Montenegro')</title>

    <link rel="stylesheet" href="{{ asset('css/estilos-index.css') }}">

    @yield('styles')
</head>
<body>

    @yield('content')

</body>
</html>