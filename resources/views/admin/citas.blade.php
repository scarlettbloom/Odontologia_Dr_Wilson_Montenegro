@extends('layouts.inicio_sesion')

@section('title', 'Citas - Administrador')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/citas.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="header">
        <h1>ADMINISTRADOR</h1>
        <h2>Gestión de Citas</h2>
        
</form>
         <a href="{{ route('inventario.index') }}">
            <button type="button" class="btn-inventario">
                Inventario
            </button>
        </a>
<form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn-cerrarsesion">Cerrar sesión</button>
            </form>
            <form action="{{ route('admin.servicios.create') }}" method="GET" style="display:inline;">
    <button type="submit" class="btn-servicios">
        🦷 Ver Servicios
    </button>
        </form>
    </div>

    <!-- FORMULARIO AGENDAR / EDITAR -->
    <div class="form-section">
        <h2 class="list-title">
            {{ isset($citaEditar) ? '✏️ Editar Cita' : '➕ Agendar Nueva Cita' }}
        </h2>
        <form method="POST" action="{{ isset($citaEditar) ? route('admin.citas.update', $citaEditar->IDcita) : route('admin.citas.store') }}">
            @csrf
            @if(isset($citaEditar))
                @method('PUT')
            @endif
            <table class="form-table">
                <tr>
                    <th>Fecha Entrada:</th>
                    <th>Fecha Salida:</th>
                    <th>Tipo:</th>
                    <th>Cliente:</th>
                    <th>Estado:</th>
                    <th>Acción:</th>
                </tr>
                <tr>
                    <td><input type="datetime-local" name="fechaEntrada"
                               value="{{ isset($citaEditar) ? \Carbon\Carbon::parse($citaEditar->Fecha_entrada)->format('Y-m-d\TH:i') : '' }}"
                               required></td>
                    <td><input type="datetime-local" name="fechaSalida"
                               value="{{ isset($citaEditar) ? \Carbon\Carbon::parse($citaEditar->Fecha_salida)->format('Y-m-d\TH:i') : '' }}"
                               required></td>
                    <td><input type="text" name="tipo"
                               value="{{ isset($citaEditar) ? $citaEditar->Tipo : '' }}"
                               required></td>
                    <td>
                        <select name="idcliente" required>
                            <option value=""> Seleccione Cliente</option>
                            @foreach($cliente as $c)
                                <option value="{{ $c->IDcliente }}"
                                    {{ isset($citaEditar) && $citaEditar->IDcliente == $c->IDcliente ? 'selected' : '' }}>
                                    {{ $c->Email }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="estado" required>
                            @foreach(['Pendiente','Confirmada','Cancelada','Atendida'] as $estado)
                                <option value="{{ $estado }}"
                                    {{ isset($citaEditar) && $citaEditar->Estado == $estado ? 'selected' : '' }}>
                                    {{ $estado }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        @if(isset($citaEditar))
                            <button type="submit" class="btn-agendar">💾 Guardar cambios</button>
                            <a href="{{ route('admin.citas.index') }}" class="btn-cancelar">❌ Cancelar</a>
                        @else
                            <button type="submit" class="btn-agendar">📅 Agendar</button>
                        @endif
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <!-- BUSCADOR -->
    <div class="search-bar">
        <form method="GET" action="{{ route('admin.citas.index') }}">
            <input type="text" name="search" placeholder="Buscar por correo, estado o tipo..."
                   value="{{ request('search') }}">
            <button type="submit">Buscar</button>
        </form>
    </div>

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
                            <a href="{{ route('admin.citas.edit', $cita->IDcita) }}" class="btn-warning">✏️ Editar</a>
                            <form action="{{ route('admin.citas.destroy', $cita->IDcita) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar esta cita?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger">🗑️ Eliminar</button>
                            </form>
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
