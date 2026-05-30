<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dr. Wilson Montenegro')</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<header>
    <div class="back">
        <div class="menu container">
            <img src="{{ asset('img/WILSON.png') }}" width="50" height="50" class="logo">
            <input type="checkbox" id="menu" />
            <label for="menu">
                <img src="{{ asset('img/menu.png') }}" class="menu-icono" alt="">
            </label>
            <nav class="navbar">
                <ul>
                    <li><a href="{{ route('inicio') }}">Inicio</a></li>
                    <li><a href="{{ route('mision') }}">Misión</a></li>
                    <li><a href="{{ route('vision') }}">Visión</a></li>
                    <li><a href="{{ route('objetivos') }}">Objetivos estratégicos</a></li>
                    <li><a href="{{ route('servicios') }}">Servicios</a></li>
                    <li><a href="{{ route('register') }}">Registrarse</a></li>
                    <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<br><br><br>

<main>
    @yield('content')
</main>

<br><br><br>

<footer>
    <div class="footer-container">
        <div class="footer-col">
            <h4>Dr. Wilson Montenegro</h4>
            <p>Odontología General y Especializada</p>
        </div>
        <div class="footer-col">
            <h4>Contacto</h4>
            <p>📞 +57 318 5377946</p>
            <p>📧 contacto@odontologia.com</p>
            <p>📍 Bogotá, Colombia</p>
        </div>
        <div class="footer-col">
            <h4>Créditos</h4>
            <p>Hecho por:<br> Lucas Toro y Andrés Barrios</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 - Todos los derechos reservados</p>
    </div>
</footer>

</body>
</html>
