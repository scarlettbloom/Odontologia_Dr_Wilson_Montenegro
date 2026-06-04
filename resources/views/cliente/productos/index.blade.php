@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <h1 class="text-center mb-4">
                Productos
            </h1>

            <div class="row mb-3">

                <div class="col-md-4">
                    <input type="text"
                           class="form-control"
                           placeholder="Buscar producto">
                </div>

                <div class="col-md-8 text-end">
                    <a href="{{ route('cliente.carrito') }}"
                       class="btn btn-dark">
                        🛒 Carrito
                    </a>
                </div>

            </div>

            <table class="table table-bordered table-hover">

                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Marca</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($productos as $producto)

                    <tr>

                        <td>{{ $producto->nombre }}</td>

                        <td>{{ $producto->marca }}</td>

                        <td>
                            ${{ number_format($producto->precio,0,',','.') }}
                        </td>

                        <td>

                            <a href="{{ route('cliente.producto.detalle',$producto->idproducto) }}"
                               class="btn btn-primary btn-sm">
                                Detalles
                            </a>

                            <button class="btn btn-warning btn-sm">
                                Añadir
                            </button>

                            <button class="btn btn-success btn-sm">
                                Comprar
                            </button>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4">
                            No existen productos registrados
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection