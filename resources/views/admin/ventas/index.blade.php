@extends('layouts.ventas')

@section('content')
<div class="ventas-container">
    <div class="container">
        <link rel="stylesheet" href="{{ asset('css/ventas.css') }}">

        <div class="ventas-wrapper">
            <div class="ventas-header">
                <h1>Módulo de Ventas</h1>
                <span class="user-role">Administrador</span>
            </div>
 
<a href="{{ route('admin.ventas.reporte') }}" class="btn-ventas">
     ventas realizadas
</a>

            {{-- BOTÓN VOLVER --}}
            <a href="{{ route('admin.citas.index') }}" class="btn btn-secondary volver-btn">
                Volver
            </a>

            {{-- MENSAJES --}}
            @if(session('error'))
                <div class="alert alert-danger" style="margin-top: 10px;">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success" style="margin-top: 10px;">
                    {{ session('success') }}
                </div>
            @endif

            {{-- BUSCADOR --}}
            <div class="search-box">
                <input type="text" id="buscar" placeholder="Buscar producto...">
                <button class="btn btn-primary">Buscar</button>
            </div>

            <div class="ventas-grid">

                {{-- INVENTARIO --}}
                <div class="inventario-box">
                    <h2>Productos disponibles</h2>

                    <table class="ventas-table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $p)
                            <tr>
                                <td>{{ $p->nombre }}</td>
                                <td>${{ $p->precio_unitario }}</td>
                                <td>{{ $p->stock }}</td>
                                <td>
                                    <button class="btn btn-primary btn-add"
                                        onclick="agregarProducto({{ $p->idinventario }}, '{{ $p->nombre }}', {{ $p->precio_unitario }}, {{ $p->stock }})">
                                        + Agregar
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- CARRITO --}}
                <div class="carrito-box">
                    <h2>Carrito de venta</h2>


                    <table class="ventas-table" id="tabla-carrito">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cant.</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="carrito-body">
                            {{-- Se llena con JS --}}
                        </tbody>
                    </table>

                    <div class="totales-box">
                        <p>Subtotal: <span id="subtotal">$0</span></p>
                        <p>Descuento: <input type="number" id="descuento" value="0" min="0"></p>
                        <p class="total">Total: <span id="total">$0</span></p>
                    </div>

                    <form action="{{ route('admin.ventas.store') }}" method="POST" id="form-venta">
                        @csrf
                        <input type="hidden" name="carrito" id="input-carrito">
                        <input type="hidden" name="descuento" id="input-descuento">

                        <button type="submit" class="btn btn-primary">Guardar venta</button>
                        <a href="{{ route('admin.ventas.index') }}" class="btn btn-danger">Cancelar</a>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
let carrito = [];

/* ------------------------------
   AGREGAR PRODUCTO AL CARRITO
--------------------------------*/
function agregarProducto(id, nombre, precio_unitario, stock) {
    let existe = carrito.find(p => p.id == id);

    if (existe) {
        if (existe.cantidad + 1 > stock) {
            alert("No puedes agregar más. Stock disponible: " + stock);
            return;
        }
        existe.cantidad++;
    } else {
        carrito.push({
            id,
            nombre,
            precio: parseFloat(precio_unitario),
            cantidad: 1,
            stock: parseInt(stock)
        });
    }

    renderCarrito();
}

/* ------------------------------
   ELIMINAR PRODUCTO
--------------------------------*/
function eliminarProducto(id) {
    carrito = carrito.filter(p => p.id != id);
    renderCarrito();
}

/* ------------------------------
   CAMBIAR CANTIDAD
--------------------------------*/
function cambiarCantidad(id, nuevaCantidad) {
    let prod = carrito.find(p => p.id == id);

    if (parseInt(nuevaCantidad) > prod.stock) {
        alert("No puedes vender más de " + prod.stock + " unidades.");
        return;
    }

    prod.cantidad = parseInt(nuevaCantidad);
    renderCarrito();
}

/* ------------------------------
   RENDERIZAR CARRITO
--------------------------------*/
function renderCarrito() {
    let tbody = document.getElementById("carrito-body");
    tbody.innerHTML = "";

    let subtotal = 0;

    carrito.forEach(p => {
        let sub = p.precio * p.cantidad;
        subtotal += sub;

        tbody.innerHTML += `
            <tr>
                <td>${p.nombre}</td>
                <td>
                    <input type="number" min="1" value="${p.cantidad}" 
                        onchange="cambiarCantidad('${p.id}', this.value)">
                </td>
                <td>$${p.precio.toFixed(2)}</td>
                <td>$${sub.toFixed(2)}</td>
                <td><button class="btn btn-danger" onclick="eliminarProducto('${p.id}')">X</button></td>
            </tr>
        `;
    });

    document.getElementById("subtotal").innerText = "$" + subtotal.toFixed(2);

    let descuento = parseFloat(document.getElementById("descuento").value) || 0;
    let total = subtotal - descuento;

    document.getElementById("total").innerText = "$" + total.toFixed(2);

    document.getElementById("input-carrito").value = JSON.stringify(carrito);
    document.getElementById("input-descuento").value = descuento;
}
</script>
@endsection
