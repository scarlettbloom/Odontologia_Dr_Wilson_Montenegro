@extends('layouts.cliente')

@section('content')

<link rel="stylesheet" href="{{ asset('css/modulo_cliente_ventas.css') }}">

<div class="checkout-container">

    <h1>Finalizar Compra</h1>

    <form action="{{ route('cliente.checkout') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" required>
        </div>

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" name="direccion" required>
        </div>

        <div class="form-group">
            <label for="metodo_pago">Método de pago</label>
            <select name="metodo_pago" required>
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta</option>
                <option value="transferencia">Transferencia</option>
            </select>
        </div>

        <div class="form-group">
            <label for="descuento">Descuento (opcional)</label>
            <input type="number" name="descuento" min="0" step="0.01">
        </div>

        <button type="submit" class="btn-confirmar">Confirmar compra</button>
    </form>

</div>

@endsection

