@extends('layouts.app')

@section('content')
<div class="venta-container">

    <h2 class="venta-title">Venta registrada correctamente</h2>

    <p class="venta-info">Número de factura: {{ $numeroFactura }}</p>
    <p class="venta-info">Total pagado: ${{ number_format($totalPagado, 0, ',', '.') }}</p>

    <a href="{{ route('admin.ventas.index') }}" class="btn-nueva-venta">
        Nueva venta
    </a>

    <button class="btn-comprobante">
        Ver comprobante
    </button>

</div>
@endsection
