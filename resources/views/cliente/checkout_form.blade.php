@extends('layouts.inventario_cliente')

@section('content')
<div class="container">
    <h2 class="text-center">Confirmar compra</h2>

    <h4>Productos seleccionados:</h4>

    <table class="table table-bordered text-center">
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

    <h3 class="text-end">Total: ${{ number_format($total, 0, ',', '.') }}</h3>

    <hr>

    <h4>Datos del comprador</h4>

    <form action="{{ route('cliente.checkout') }}" method="POST">
        @csrf

        <input type="hidden" name="productos_seleccionados" value="{{ implode(',', array_column($productosAComprar, 'id')) }}">

        <div class="mb-3">
            <label>Nombre completo</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control" required>
        </div>

        <div class="mb-3">
    <label>Método de pago</label>
    <select name="metodo_pago" id="metodo_pago" class="form-control" required onchange="mostrarSubformulario()">
        <option value="">Seleccione un método</option>
        <option value="Efectivo">Efectivo</option>
        <option value="Tarjeta">Tarjeta</option>
        <option value="Transferencia">Transferencia</option>
    </select>
</div>
    <div id="subformulario_tarjeta" style="display:none;">
    <h5>Datos de la tarjeta</h5>

    <div class="mb-3">
        <label>Número de tarjeta</label>
        <input type="text" name="numero_tarjeta" class="form-control" maxlength="16" pattern="\d{16}" placeholder="Ejemplo: 1234 5678 9012 3456">
    </div>

    <div class="mb-3">
        <label>Fecha de vencimiento</label>
        <input type="month" name="fecha_vencimiento" class="form-control">
    </div>

    <div class="mb-3">
        <label>Código de seguridad (CVV)</label>
        <input type="text" name="cvv" class="form-control" maxlength="3" pattern="\d{3}" placeholder="Ejemplo: 123">
    </div>
</div>



        <button type="submit" class="btn btn-success w-100">Confirmar compra</button>
    </form>
</div>

<script>
function mostrarSubformulario() {
    const metodo = document.getElementById('metodo_pago').value;
    const subform = document.getElementById('subformulario_tarjeta');

    if (metodo === 'Tarjeta') {
        subform.style.display = 'block';
    } else {
        subform.style.display = 'none';
    }
}
</script>

@endsection
