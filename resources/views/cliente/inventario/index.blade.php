@extends('layouts.inventario_cliente')

@section('content')
<div class="inventario-container">
    <h1 class="text-center">Inventario Disponible</h1>    
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Proveedor</th>
                <th>Precio</th>
                <th>Stock disponible</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->nombre_proveedor }}</td>
                <td>${{ number_format($producto->precio_unitario, 0, ',', '.') }}</td>
                <td>{{ $producto->stock }}</td>
                <td>
                    <a href="{{ route('cliente.inventario.detalle', $producto->idinventario) }}" class="btn btn-secondary btn-sm">Detalles</a>

                    @if($producto->stock > 0)
                        <a href="{{ route('cliente.inventario.carrito', $producto->idinventario) }}" class="btn btn-primary btn-sm">🛒 Añadir al carrito</a>
                    @else
                        <button class="btn btn-secondary btn-sm" disabled>Sin stock</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
