<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Movimiento de Stock</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 40px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            margin-bottom: 20px;
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }

        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background-color: #3498db;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 16px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>

    <h1>Movimiento de Stock</h1>
    <a href="{{ route('empleado.ventas.reporte') }}">← Volver al reporte de ventas</a>

    <table>
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
                <td>{{ $item->updated_at ? $item->updated_at->format('d/m/Y H:i') : 'Sin cambios' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Sistema de Inventario © {{ date('Y') }}
    </div>

</body>
</html>
