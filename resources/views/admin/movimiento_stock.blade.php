<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Movimiento de Stock</title>

    <!-- CSS del módulo de ventas -->
     <link rel="stylesheet" href="{{ asset('css/modulo_inventario.css') }}">
</head>

<body class="mov-stock-body">

    <h1 class="mov-stock-title">Movimiento de Stock</h1>

    <a href="{{ route('admin.ventas.reporte') }}" class="mov-stock-back">
        ← Volver al reporte de ventas
    </a>

    <table class="mov-stock-table">
        <thead>
            <tr>
                <th class="mov-stock-th">Producto</th>
                <th class="mov-stock-th">Stock Actual</th>
                <th class="mov-stock-th">Última Actualización</th>
            </tr>
        </thead>

        <tbody>
            @foreach($inventario as $item)
            <tr class="mov-stock-row">
                <td class="mov-stock-td">{{ $item->nombre }}</td>
                <td class="mov-stock-td">{{ $item->stock }}</td>
                <td class="mov-stock-td">
                    {{ $item->ultima_actualizacion 
                        ? \Carbon\Carbon::parse($item->ultima_actualizacion)->format('d/m/Y H:i')
                        : 'Sin cambios'
                    }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mov-stock-footer">
        Sistema de Inventario © {{ date('Y') }}
    </div>

</body>
</html>



