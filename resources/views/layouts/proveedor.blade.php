<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Proveedores')</title>

    <!-- Fuente y estilos base -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
        }

        header .user {
            font-weight: 600;
            color: #475569;
        }

        main {
            padding: 40px;
        }

        footer {
            background-color: #ffffff;
            text-align: center;
            padding: 15px;
            font-size: 0.9rem;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }

        /* Botones */
        .btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #2563eb;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #1e40af;
        }

        .btn-secondary {
            background-color: #f1f5f9;
            color: #1e293b;
        }

        .btn-secondary:hover {
            background-color: #e2e8f0;
        }

        /* Contenedor principal */
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .card h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1e293b;
            border-bottom: 3px solid #2563eb;
            display: inline-block;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Panel de Proveedores</h1>
        <div class="user">Administrador</div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        © {{ date('Y') }} - Todos los derechos reservados
    </footer>
</body>
</html>
