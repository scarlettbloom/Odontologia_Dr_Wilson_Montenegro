@extends('layouts.proveedor')

@section('content')
<style>
    body {
        background-color: #f8fafc !important; /* color gris claro */
    }

    main {
        background-color: transparent !important; /* elimina el fondo azul del contenedor principal */
    }

    .container-proveedor {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        padding: 30px;
        margin: 40px auto;
        width: 90%;
        max-width: 800px;
    }

    .container-proveedor h2 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1e293b;
        border-bottom: 3px solid #2563eb;
        display: inline-block;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 600;
        color: #334155;
        display: block;
        margin-bottom: 8px;
    }

    .form-group input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .form-group input:focus {
        border-color: #2563eb;
        outline: none;
    }

    .btn-guardar {
        background-color: #2563eb;
        color: #fff;
        font-weight: 600;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-guardar:hover {
        background-color: #1e40af;
    }

    .btn-volver {
        display: inline-block;
        margin-bottom: 20px;
        color: #2563eb;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s;
    }

    .btn-volver:hover {
        color: #1e40af;
    }
</style>

<div class="container-proveedor">
    <a href="{{ route('admin.inventario.index') }}" class="btn-volver">← Volver al Inventario</a>
    <h2>Nuevo proveedor</h2>

    <form action="{{ route('admin.proveedors.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>

        <div class="form-group">
            <label for="contacto">Contacto</label>
            <input type="text" name="contacto" id="contacto">
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" id="telefono">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" name="direccion" id="direccion">
        </div>

        <button type="submit" class="btn-guardar">Guardar</button>
    </form>
</div>
@endsection
