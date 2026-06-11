@extends('layouts.inventario_cliente')

@section('title', 'Carrito')

@section('content')
<div class="card shadow p-4">
    <h1 class="text-center mb-4">Carrito</h1>

    <table class="table table-bordered text-center align-middle">
        <thead class="table-primary">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            @forelse($carrito as $item)
                <tr>
                    <td>
    {{ $item->nombre }}
    <input type="hidden" class="prod-id" value="{{ $item->idinventario }}">
</td>

                    <td><input type="number" min="1" value="1" class="form-control text-center w-50 mx-auto"></td>
                    <td>${{ number_format($item->precio_unitario, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-muted py-4">Tu carrito está vacío 🛒</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="text-center mt-4">
        <form action="{{ route('cliente.checkout') }}" method="POST" id="form-cliente">

            @csrf
            <input type="hidden" name="carrito" id="input-carrito">
            <input type="hidden" name="descuento" id="input-descuento" value="0">

            <button type="submit" class="btn btn-outline-success btn-lg">Comprar</button>
        </form>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('cliente.inventario') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>

<script>
document.getElementById('form-cliente').addEventListener('submit', function(e) {

    let filas = document.querySelectorAll("tbody tr");
    let carrito = [];

    filas.forEach(fila => {
        let id = fila.querySelector(".prod-id").value;
        let nombre = fila.children[0].innerText.trim();
        let cantidad = fila.children[1].querySelector("input").value;
        let precio = fila.children[2].innerText.replace('$', '').replace(/\./g, '');

        carrito.push({
            id: parseInt(id),
            nombre: nombre,
            cantidad: parseInt(cantidad),
            precio: parseFloat(precio)
        });
    });

    document.getElementById("input-carrito").value = JSON.stringify(carrito);
});
</script>


@endsection

