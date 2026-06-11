@extends('layouts.ventas')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ventas.css') }}">

<div class="ventas-container">
    <div class="container">

        <div class="ventas-wrapper">

            <div class="ventas-header">
                <h1>Reporte de Ventas</h1>
                <span class="user-role">Empleado</span>
            </div>

            <a href="{{ route('admin.ventas.index') }}" class="btn btn-secondary volver-btn">
                ⬅ Volver al módulo de ventas
            </a>



            <div class="reporte-box">

                <table class="ventas-table">
                    <thead>
                        <tr>
                            <th>ID Venta</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Descuento</th>
                            <th>Total</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($ventas as $v)
                        <tr>
                            <td>{{ $v->idventa }}</td>
                            <td>{{ $v->producto->nombre ?? 'Producto eliminado' }}</td>
                            <td>{{ $v->cantidad }}</td>
                            <td>${{ number_format($v->subtotal, 2) }}</td>
                            <td>${{ number_format($v->descuento, 2) }}</td>
                            <td>${{ number_format($v->total, 2) }}</td>
                            <td>{{ $v->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay ventas registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>

@endsection

