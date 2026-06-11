@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>Venta registrada correctamente</h2>
    <p>Número de factura: {{ $numeroFactura }}</p>
    <p>Total pagado: ${{ number_format($totalPagado, 0, ',', '.') }}</p>

    <a href="{{ route('admin.ventas.index') }}" class="btn btn-primary">Nueva venta</a>
    <button class="btn btn-secondary">Ver comprobante</button>
</div>
@endsection
