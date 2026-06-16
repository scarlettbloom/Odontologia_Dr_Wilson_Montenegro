@extends('layouts.inventario_cliente')

@section('title', 'Detalle del Producto')

@section('content')
<div class="card shadow p-4">
    <h1 class="text-center mb-4">Detalle del Producto</h1>

    <table class="table table-bordered text-center align-middle">
        <thead class="table-primary">
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $producto->nombre }}</td>
                <td>${{ number_format($producto->precio_unitario, 0, ',', '.') }}</td>
                <td>{{ $producto->descripcion ?? 'Sin descripción disponible' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="text-center mt-3">
        <a href="{{ route('cliente.inventario.carrito',$producto->idinventario) }}" class="btn btn-outline-primary btn-sm">🛒 Añadir al carrito</a>
        <button class="btn btn-outline-success btn-sm">Comprar</button>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('cliente.inventario') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
