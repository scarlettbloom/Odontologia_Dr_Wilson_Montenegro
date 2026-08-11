@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/modulo_empleado_ventas.css') }}">

<div class="ventas-confirmacion">

    <h2>Venta registrada correctamente</h2>

    <p>Número de factura: {{ $numeroFactura }}</p>
    <p>Total pagado: ${{ number_format($totalPagado, 0, ',', '.') }}</p>

    <a href="{{ route('empleado.ventas.index') }}" class="btn-nueva-venta">
        Nueva venta
    </a>

    <button class="btn-comprobante">
        Ver comprobante
    </button>

</div>

@endsection

