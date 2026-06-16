@extends('layouts.inventario_cliente')

@section('content')
<div class="carrito-container">
    <h1 class="text-center">🛒 Carrito</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(count($carrito) > 0)

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Seleccionar</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($carrito as $item)
            <tr>
                <td>
                    <input type="checkbox" form="checkoutForm" name="productos_seleccionados[]" value="{{ $item['id'] }}">
                </td>

                <td>{{ $item['nombre'] }}</td>

                <td>
                    <form action="{{ route('cliente.carrito.actualizar', $item['id']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input 
                            type="number" 
                            name="cantidad" 
                            value="{{ $item['cantidad'] }}" 
                            min="1" 
                            style="width:60px; text-align:center;"
                            onchange="this.form.submit()"
                        >
                    </form>
                </td>

                <td>${{ number_format($item['precio'], 0, ',', '.') }}</td>

                <td>${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}</td>

                <td>
                    <a href="{{ route('cliente.carrito.eliminar', $item['id']) }}" class="btn btn-danger btn-sm">Eliminar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 id="totalSeleccionado" class="text-end">Total seleccionado: $0</h4>


    <!-- FORMULARIO DEL CHECKOUT (SEPARADO) -->
    <form id="checkoutForm" action="{{ route('cliente.checkout_form') }}" method="POST">
        @csrf
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-success">Finalizar compra seleccionada</button>
            <a href="{{ route('cliente.inventario') }}" class="btn btn-secondary">Seguir comprando</a>
        </div>
    </form>

    @else
        <p class="text-center">Tu carrito está vacío.</p>
        <div class="text-center">
            <a href="{{ route('cliente.inventario') }}" class="btn btn-primary">Ver productos</a>
        </div>
    @endif
</div>

<script>
    function actualizarTotal() {
        let total = 0;
        document.querySelectorAll('input[name="productos_seleccionados[]"]:checked').forEach(checkbox => {
            const fila = checkbox.closest('tr');
            const subtotalTexto = fila.querySelector('td:nth-child(5)').innerText.replace('$', '').replace('.', '').replace(',', '');
            const subtotal = parseFloat(subtotalTexto);
            total += subtotal;
        });
        document.getElementById('totalSeleccionado').innerText = 'Total seleccionado: $' + total.toLocaleString('es-CO');
    }

    // Actualizar total cuando se seleccionan productos
    document.querySelectorAll('input[name="productos_seleccionados[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', actualizarTotal);
    });

    // Calcular total inicial
    actualizarTotal();
</script>

@endsection
