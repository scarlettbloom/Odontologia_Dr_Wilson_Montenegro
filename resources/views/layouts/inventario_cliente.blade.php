<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #007bff;
            font-family: 'Segoe UI', sans-serif;
            color: #000;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
        }

        h1 {
            font-weight: bold;
            color: #004080;
        }
        .btn-warning {
    background-color: #ffc107;
    color: #000;
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    font-weight: 500;
}
.btn-warning:hover {
    background-color: #e0a800;
    color: #fff;
}

        

        .btn-cerrarsesion {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
        }

        footer {
            background-color: #002b5c;
            color: #fff;
            padding: 20px 0;
            margin-top: 40px;
        }

        footer h5 {
            font-weight: bold;
        }

        footer p, footer a {
            color: #fff;
            font-size: 14px;
        }

        
    </style>
</head>
<body>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="text-white fw-bold">CLIENTE</h2>
    <div>
     
        <a href="{{ route('cliente.citas.index') }}" class="btn btn-warning ms-2">Volver a Citas</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn-cerrarsesion ms-2">Cerrar sesión</button>
        </form>
    </div>
</div>

        @yield('content')
    </div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <footer>
        <div class="container text-center">
            <div class="row">
                <div class="col-md-4">
                    <h5>Dr. Wilson Montenegro</h5>
                    <p>Odontología General y Especializada</p>
                </div>
                <div class="col-md-4">
                    <h5>Contacto</h5>
                    <p>📞 +57 318 5377946</p>
                    <p>✉️ contacto@odontologia.com</p>
                    <p>📍 Bogotá, Colombia</p>
                </div>
                <div class="col-md-4">
                    <h5>Créditos</h5>
                    <p>Hecho por:<br>Lucas Toro y Andrés Barrios</p>
                </div>
            </div>
            <p class="mt-3">© 2024 - Todos los derechos reservados</p>
        </div>
    </footer>

</body>
</html>
