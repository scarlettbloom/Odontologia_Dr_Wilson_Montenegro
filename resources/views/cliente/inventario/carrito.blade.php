@extends('layouts.cliente')

@section('content')
<div class="inventario-container">
    <h1 class="text-center">Inventario Disponible</h1>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Proveedor</th>
                <th>Precio</th>
                <th>Stock disponible</th> <!-- Nueva columna -->
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->nombre_proveedor }}</td>
                <td>${{ number_format($producto->precio_unitario, 0, ',', '.') }}</td>
                <td>{{ $producto->stock }}</td> <!-- Mostrar stock real -->
                <td>
                    <a href="{{ route('cliente.inventario.detalle', $producto->idinventario) }}" class="btn btn-secondary btn-sm">Detalles</a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

