@extends('layouts.inicio_sesion')

@section('title', 'Mis Citas - Cliente')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/citascliente.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="header">
        <h1>CLIENTE</h1>
        <h2>Agenda de Citas</h2>
            <form action="{{ route('cliente.productos') }}" method="GET" style="display:inline;">
    <button type="submit" class="btn-cliente">
         Cliente
    </button>
</form>
    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn-cerrarsesion">Cerrar sesión</button>
        </form>
        <form action="{{ route('servicios') }}" method="GET" style="display:inline;">
    <button type="submit" class="btn-servicios">
        🦷 Ver Servicios
    </button>
</form>
    </div>

    <!-- FORMULARIO AGENDAR / EDITAR -->
    @if(!isset($citaEditar))
        <div class="form-section">
            <h2 class="list-title">➕ Agendar Nueva Cita</h2>
            <form method="POST" action="{{ route('cliente.citas.store') }}">
                @csrf
                <table class="form-table">
                    <tr>
                        <th>Fecha Entrada:</th>
                        <th>Fecha Salida:</th>
                        <th>Tipo:</th>
                        <th>Correo Cliente:</th>
                        <th>Acción:</th>
                    </tr>
                    <tr>
                        <td><input type="datetime-local" name="fechaEntrada" required></td>
                        <td><input type="datetime-local" name="fechaSalida" required></td>
                        <td><input type="text" name="tipo" required></td>
                        <td><input type="email" name="correo" placeholder="cliente@ejemplo.com" required></td>
                        <td><button type="submit" class="btn-agendar">📅 Agendar</button></td>
                    </tr>
                </table>
            </form>
        </div>
    @else
        <div class="form-section">
            <h2 class="list-title">✏️ Editar Cita</h2>
            <form method="POST" action="{{ route('cliente.citas.update', $citaEditar->IDcita) }}">
                @csrf
                @method('PUT')
                <table class="form-table">
                    <tr>
                        <th>Fecha Entrada:</th>
                        <th>Fecha Salida:</th>
                        <th>Tipo:</th>
                        <th>Acción:</th>
                    </tr>
                    <tr>
                        <td><input type="datetime-local" name="fechaEntrada"
                                   value="{{ \Carbon\Carbon::parse($citaEditar->Fecha_entrada)->format('Y-m-d\TH:i') }}"
                                   required></td>
                        <td><input type="datetime-local" name="fechaSalida"
                                   value="{{ \Carbon\Carbon::parse($citaEditar->Fecha_salida)->format('Y-m-d\TH:i') }}"
                                   required></td>
                        <td><input type="text" name="tipo" value="{{ $citaEditar->Tipo }}" required></td>
                        <td>
                            <button type="submit" class="btn-agendar">💾 Guardar cambios</button>
                            <a href="{{ route('cliente.citas.index') }}" class="btn-danger">❌ Cancelar</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    @endif

    <!-- ALERTAS -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif


    <!-- TABLA -->
    <div class="table-section">
        <h2 class="list-title">📋 Lista de Citas</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID USUARIO</th>
                    <th>CORREO</th>
                    <th>FECHA ENTRADA</th>
                    <th>FECHA SALIDA</th>
                    <th>ESTADO</th>
                    <th>TIPO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @forelse($citas as $cita)
                    <tr>
                        <td>{{ $cita->ID }}</td>
                        <td>{{ $cita->Email }}</td>
                        <td>{{ \Carbon\Carbon::parse($cita->Fecha_entrada)->format('d/m/Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($cita->Fecha_salida)->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="estado-badge estado-{{ strtolower($cita->Estado) }}">
                                {{ $cita->Estado }}
                            </span>
                        </td>
                        <td>{{ $cita->Tipo }}</td>
                        <td>
                            <a href="{{ route('cliente.citas.edit', $cita->IDcita) }}" class="btn-warning">✏️ Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="no-data">No hay citas registradas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
