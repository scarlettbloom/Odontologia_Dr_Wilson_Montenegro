@extends('layouts.inventario_cliente')

@section('title', 'Datos de Compra')

@section('content')
<div class="card shadow p-4">
    <h1 class="text-center mb-4">Datos para la Compra</h1>

    <form action="{{ route('cliente.venta.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre completo</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección de envío</label>
            <input type="text" name="direccion" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Método de pago</label>
            <select name="metodo_pago" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="efectivo">Efectivo</option>
                <option value="transferencia">Transferencia</option>
                <option value="tarjeta">Tarjeta</option>
            </select>
        </div>

        <button class="btn btn-success w-100 mt-3">Confirmar Compra</button>
    </form>
</div>
@endsection
