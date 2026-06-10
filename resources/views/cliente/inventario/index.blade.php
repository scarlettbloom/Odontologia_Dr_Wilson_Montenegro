@extends('layouts.inventario_cliente')


@section('title', 'Inventario - Cliente')

@section('content')
<div class="card shadow p-4">
    <h1 class="text-center mb-4">Inventario Disponible</h1>

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Producto</th>
                    <th>Proveedor</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->nombre_proveedor }}</td>
                        <td>${{ number_format($producto->precio_unitario, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('cliente.inventario.detalle', $producto->idinventario) }}" class="btn btn-outline-secondary btn-sm">Detalles</a>
                            <a href="{{ route('cliente.inventario.carrito') }}" class="btn btn-outline-primary btn-sm">🛒 Añadir al carrito</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted">No hay productos disponibles</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
