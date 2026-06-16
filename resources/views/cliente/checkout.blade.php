@extends('layouts.cliente')

@section('content')
<div class="checkout-container">
    <h1 class="text-center">Finalizar Compra</h1>

    <form action="{{ route('cliente.checkout') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="metodo_pago" class="form-label">Método de pago</label>
            <select name="metodo_pago" class="form-select" required>
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta</option>
                <option value="transferencia">Transferencia</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="descuento" class="form-label">Descuento (opcional)</label>
            <input type="number" name="descuento" class="form-control" min="0" step="0.01">
        </div>

        <button type="submit" class="btn btn-success w-100">Confirmar compra</button>
    </form>
</div>
@endsection
