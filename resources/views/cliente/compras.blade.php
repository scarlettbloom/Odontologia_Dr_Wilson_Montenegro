@extends('layouts.inventario_cliente')

@section('content')

<link rel="stylesheet" href="{{ asset('css/modulo_cliente_ventas.css') }}">

<div class="compras-container">

    <h1>Historial de Compras</h1>

    @if(count($ventas) > 0)

        <table class="compras-table">
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
        <p class="no-compras">No tienes compras registradas.</p>
    @endif

</div>

@endsection


