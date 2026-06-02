@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <h1 class="text-center mb-4">
                Carrito
            </h1>

            <table class="table table-bordered">

                <thead class="table-light">

                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($carrito as $item)

                    <tr>

                        <td>{{ $item->nombre }}</td>

                        <td>{{ $item->cantidad }}</td>

                        <td>
                            ${{ number_format($item->precio,0,',','.') }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="3">
                            El carrito está vacío
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            <div class="text-end">

                <button class="btn btn-success">
                    Comprar
                </button>

            </div>

        </div>

    </div>

</div>

@endsection