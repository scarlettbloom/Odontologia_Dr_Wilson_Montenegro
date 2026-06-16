@extends('layouts.inicio_sesion')

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestión de Servicios</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#f4f8fc;
    padding:40px;
}

.container{
    max-width:1200px;
    margin:auto;
}

h1{
    text-align:center;
    color:white;
    margin-bottom:30px;
}

.btn-nuevo{
    display:inline-block;
    margin-bottom:20px;
    background:#1976d2;
    color:white;
    text-decoration:none;
    padding:12px 20px;
    border-radius:8px;
    font-weight:bold;
}

.btn-nuevo:hover{
    background:#0d47a1;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    box-shadow:0 5px 20px rgba(0,0,0,.1);
    border-radius:10px;
    overflow:hidden;
}

thead{
    background:#1976d2;
    color:white;
}

th{
    padding:16px;
    text-align:center;
}

td{
    padding:15px;
    text-align:center;
    border-bottom:1px solid #eee;
}

.btn-editar{
    background:#ffc107;
    color:black;
    padding:8px 15px;
    border-radius:6px;
    text-decoration:none;
    font-weight:bold;
    margin-right:5px;
}

.btn-eliminar{
    background:#dc3545;
    color:white;
    border:none;
    padding:8px 15px;
    border-radius:6px;
    cursor:pointer;
    font-weight:bold;
}

.btn-eliminar:hover{
    background:#b02a37;
}

.sin-datos{
    padding:20px;
    color:#666;
}

.acciones{
    display:flex;
    justify-content:center;
    gap:10px;
}

</style>

</head>
<body>
@php
    $prefix = auth()->user()->rol === 'administrador'
        ? 'admin'
        : 'empleado';
@endphp
<div class="container">

    <h1>🦷 Gestión de Servicios Odontológicos</h1>

    <a href="{{ route($prefix.'.servicios.create') }}" class="btn-nuevo">
        ➕ Registrar Servicio
    </a>

    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Servicio</th>
                <th>Descripción</th>
                <th>Costo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

        @forelse($servicios as $servicio)

            <tr>

                <td>{{ $servicio->idservicio }}</td>

                <td>{{ $servicio->nombre }}</td>

                <td>{{ $servicio->descripcion }}</td>

                <td>
                    ${{ number_format($servicio->costo,0,',','.') }}
                </td>

                <td>

                    <div class="acciones">

                        <a href="{{ route($prefix.'.servicios.edit',$servicio->idservicio) }}"
                           class="btn-editar">
                            ✏️ Editar
                        </a>

                        <form action="{{ route($prefix.'.servicios.destroy',$servicio->idservicio) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn-eliminar"
                                    onclick="return confirm('¿Desea eliminar este servicio?')">

                                🗑 Eliminar

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="5" class="sin-datos">
                    No hay servicios registrados.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

</body>
</html>
