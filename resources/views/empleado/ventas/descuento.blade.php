@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Descuento</h2>

    <label for="tipo">Tipo de descuento:</label>
    <select id="tipo" class="form-control mb-3">
        <option>Porcentual</option>
        <option>Valor fijo</option>
    </select>

    <p>Subtotal: ______</p>
    <p>Descuento: ______</p>
    <p><strong>TOTAL: ______</strong></p>

    <button class="btn btn-success">Aplicar descuento</button>
    <button class="btn btn-secondary">Cancelar</button>
</div>
@endsection
