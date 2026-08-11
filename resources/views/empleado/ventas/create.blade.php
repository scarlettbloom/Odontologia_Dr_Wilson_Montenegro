@extends('layouts.ventas')

@section('content')

<link rel="stylesheet" href="{{ asset('css/modulo_empleado_ventas.css') }}">

<div class="ventas-form-container">

    <h1 class="ventas-title">Registrar Nueva Venta</h1>

    <form action="{{ route('empleado.ventas.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="producto_id">Producto</label>
            <select name="producto_id" id="producto_id" required>
                <option value="" disabled selected>-- Selecciona un producto --</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">
                        {{ $producto->nombre }} - ${{ $producto->precio }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" min="1" required>
        </div>

        <div class="form-group">
            <label for="descuento">Descuento</label>
            <input type="number" name="descuento" id="descuento" min="0" value="0">
        </div>

        <button type="submit" class="btn-guardar">Guardar Venta</button>
        <a href="{{ route('empleado.ventas.index') }}" class="btn-cancelar">Cancelar</a>
    </form>

</div>

@endsection

