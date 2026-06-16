@extends('layouts.inventario_cliente')

@section('content')
<div class="compras-container">
    <h1 class="text-center">Historial de Compras</h1>

    @if(count($ventas) > 0)
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Descuento</th>
                    <th>Total</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->producto->nombre }}</td>
                    <td>{{ $venta->cantidad }}</td>
                    <td>${{ number_format($venta->subtotal, 0, ',', '.') }}</td>
                    <td>${{ number_format($venta->descuento, 0, ',', '.') }}</td>
                    <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                    <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center">No tienes compras registradas.</p>
    @endif
</div>
@endsection

