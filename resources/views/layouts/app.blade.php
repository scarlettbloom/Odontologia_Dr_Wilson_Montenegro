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
                    <li><a href="{{ route('inicio') }}" class="{{ request()->routeIs('inicio') ? 'active' : '' }}">Inicio</a></li>
                    <li><a href="{{ route('mision') }}" class="{{ request()->routeIs('mision') ? 'active' : '' }}">Misión</a></li>
                    <li><a href="{{ route('vision') }}" class="{{ request()->routeIs('vision') ? 'active' : '' }}">Visión</a></li>
                    <li><a href="{{ route('objetivos') }}" class="{{ request()->routeIs('objetivos') ? 'active' : '' }}">Objetivos estratégicos</a></li>
                    <li><a href="{{ route('servicios') }}" class="{{ request()->routeIs('servicios') ? 'active' : '' }}">Servicios</a></li>
                        <li><a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Registrarse</a></li>
                        <li><a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Iniciar Sesión</a></li>
                    @auth
                        <li><a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Cerrar Sesión
                        </a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    @endauth
                </ul>
            </nav>
        </div>
    </div>
</header>

@yield('content')

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
            <p>Hecho por:<br> Joel Pabon, Juan Siaucho, Laura Castro y Andrés Barrios</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 - Todos los derechos reservados</p>
    </div>
</footer>

</body>
</html>