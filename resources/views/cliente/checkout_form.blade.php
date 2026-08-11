@extends('layouts.inventario_cliente')

@section('content')

<link rel="stylesheet" href="{{ asset('css/modulo_cliente_ventas.css') }}">

<div class="checkout-container">

    <h2>Confirmar compra</h2>

    <h4>Productos seleccionados:</h4>

    <table class="checkout-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @foreach($productosAComprar as $item)
            <tr>
                <td>{{ $item['nombre'] }}</td>
                <td>{{ $item['cantidad'] }}</td>
                <td>${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total: ${{ number_format($total, 0, ',', '.') }}</h3>

    <hr>

    <h4>Datos del comprador</h4>

    <form action="{{ route('cliente.checkout') }}" method="POST">
        @csrf

        <input type="hidden" 
               name="productos_seleccionados" 
               value="{{ implode(',', array_column($productosAComprar, 'id')) }}">

        <div class="form-group">
            <label>Nombre completo</label>
            <input type="text" name="nombre" required>
        </div>

        <div class="form-group">
            <label>Teléfono</label>
            <input type="text"
                   name="telefono"
                   id="telefono"
                   maxlength="10"
                   pattern="\d{10}"
                   title="Debe contener exactamente 10 números"
                   required
                   oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10)">
        </div>

        <div class="form-group">
            <label>Dirección</label>
            <input type="text" name="direccion" required>
        </div>

        <div class="form-group">
            <label>Método de pago</label>
            <select name="metodo_pago" id="metodo_pago" required onchange="mostrarSubformulario()">
                <option value="">Seleccione un método</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Tarjeta">Tarjeta</option>
                <option value="Transferencia">Transferencia</option>
            </select>
        </div>

        <div id="subformulario_tarjeta" style="display:none;">
            <h5>Datos de la tarjeta</h5>

            <div class="form-group">
                <label>Número de tarjeta</label>
                <input type="text" name="numero_tarjeta" maxlength="16" pattern="\d{16}" placeholder="Ejemplo: 1234567890123456">
            </div>

            <div class="form-group">
                <label>Fecha de vencimiento</label>
                <input type="month" name="fecha_vencimiento">
            </div>

            <div class="form-group">
                <label>Código de seguridad (CVV)</label>
                <input type="text" name="cvv" maxlength="3" pattern="\d{3}" placeholder="Ejemplo: 123">
            </div>
        </div>

        <button type="submit" class="btn-confirmar">Confirmar compra</button>
    </form>

</div>

<script>
function mostrarSubformulario() {
    const metodo = document.getElementById('metodo_pago').value;
    const subform = document.getElementById('subformulario_tarjeta');

    subform.style.display = metodo === 'Tarjeta' ? 'block' : 'none';
}
</script>

@endsection

