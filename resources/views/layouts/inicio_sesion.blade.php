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
