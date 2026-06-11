@extends('layouts.inventario_cliente')

@section('title', 'Producto en Carrito')

@section('content')
<div class="card shadow p-4">
    <h1 class="text-center mb-4">Producto añadido al carrito</h1>

    <table class="table table-bordered text-center align-middle">
        <thead class="table-primary">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>{{ $producto->nombre }}</td>

                <td>
                    <input type="number" min="1" value="1"
                           class="form-control text-center w-50 mx-auto">
                </td>

                <td>${{ number_format($producto->precio_unitario, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="{{ route('cliente.inventario') }}" class="btn btn-secondary">Volver al inventario</a>
    </div>
</div>
@endsection
