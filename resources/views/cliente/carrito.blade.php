@extends('layouts.inventario_cliente')

@section('title', 'Carrito')

@section('content')
<div class="card shadow p-4">
    <h1 class="text-center mb-4">Carrito</h1>

    <table class="table table-bordered text-center align-middle">
        <thead class="table-primary">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            @forelse($carrito as $item)
                <tr>
                    <td>{{ $item->nombre }}</td>
                    <td><input type="number" min="1" value="1" class="form-control text-center w-50 mx-auto"></td>
                    <td>${{ number_format($item->precio_unitario, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-muted py-4">Tu carrito está vacío 🛒</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="text-center mt-4">
        <button class="btn btn-outline-success btn-lg">Comprar</button>
    </div>
</div>
@endsection
