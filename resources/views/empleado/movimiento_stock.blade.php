<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Movimiento de Stock</title>

    <!-- Tailwind + FontAwesome -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS del módulo inventario empleado -->
    <link rel="stylesheet" href="{{ asset('css/_modulo_inventario_empleado.css') }}">
</head>

<body class="bg-slate-100 font-sans">

<div class="movimiento-container">

    <h1 class="movimiento-title">Movimiento de Stock</h1>

    <a href="{{ route('empleado.ventas.reporte') }}" class="btn-volver">
        ← Volver al reporte de ventas
    </a>

    <div class="table-container">
        <table class="table-stock">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Stock Actual</th>
                    <th>Última Actualización</th>
                </tr>
            </thead>

            <tbody>
                @foreach($inventario as $item)
                <tr>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>
                        {{ $item->ultima_actualizacion 
                            ? \Carbon\Carbon::parse($item->ultima_actualizacion)->format('d/m/Y H:i')
                            : 'Sin cambios'
                        }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Sistema de Inventario © {{ date('Y') }}
    </div>

</div>

</body>
</html>

