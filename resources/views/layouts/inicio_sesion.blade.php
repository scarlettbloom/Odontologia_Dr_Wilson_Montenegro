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

</body>
</html>
