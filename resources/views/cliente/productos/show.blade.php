@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <h1 class="text-center mb-4">
                Detalle del Producto
            </h1>

            <table class="table table-bordered">

                <tr>
                    <th>Nombre</th>
                    <td>{{ $producto->nombre }}</td>
                </tr>

                <tr>
                    <th>Marca</th>
                    <td>{{ $producto->marca }}</td>
                </tr>

                <tr>
                    <th>Precio</th>
                    <td>
                        ${{ number_format($producto->precio,0,',','.') }}
                    </td>
                </tr>

            </table>

            <div class="mt-3">

                <button class="btn btn-warning">
                    Añadir al carrito
                </button>

                <button class="btn btn-success">
                    Comprar
                </button>

                <a href="{{ route('cliente.productos') }}"
                   class="btn btn-secondary">
                    Volver
                </a>

            </div>

        </div>

    </div>

</div>

@endsection