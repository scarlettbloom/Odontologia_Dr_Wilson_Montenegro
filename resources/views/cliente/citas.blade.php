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

            <a href="{{ route('cliente.inventario') }}">
                <button type="button" class="btn-ventas ">
                    Ventas
                </button>
            </a>

            <a href="{{ route('servicios.publicos') }}">
                <button type="button" class="btn-servicios">
                    Servicios
                </button>
            </a>

            <a href="{{ route('cliente.inventario') }}">
                <button type="button" class="btn-inventario">
                    Inventario
                </button>
            </a>

            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-cerrarsesion">Cerrar sesión</button>
            </form>
        </div>

        <!-- FORMULARIO AGENDAR / EDITAR -->
        @if (!isset($citaEditar))
            <div class="form-section">
                <h2 class="list-title">➕ Agendar Nueva Cita</h2>
                <form method="POST" action="{{ route('cliente.citas.store') }}">
                    @csrf
                    <table class="form-table">
                        <tr>
                            <th>Fecha Entrada:</th>
                            <th>Servicio:</th>
                            <th>Acción:</th>
                        </tr>
                        <tr>
                            <td><input type="datetime-local" name="fechaEntrada" required></td>
                            <td>
                                <select name="idservicio" required>
                                    <option value="">Seleccione servicio</option>

                                    @foreach ($servicios as $servicio)
                                        <option value="{{ $servicio->IDservicio }}">
                                            {{ $servicio->Nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

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
                            <th>Servicio:</th>
                            <th>Acción:</th>
                        </tr>
                        <tr>
                            <td><input type="datetime-local" name="fechaEntrada"
                                    value="{{ \Carbon\Carbon::parse($citaEditar->Fecha_entrada)->format('Y-m-d\TH:i') }}"
                                    required></td>
                            <td>
                                <select name="idservicio" required>
                                    @foreach ($servicios as $servicio)
                                        <option value="{{ $servicio->IDservicio }}"
                                            {{ $citaEditar->IDservicio == $servicio->IDservicio ? 'selected' : '' }}>
                                            {{ $servicio->Nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
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
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif


        <!-- TABLA -->
        <div class="table-section">
            <h2 class="list-title">📋 Lista de Citas</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>NOMBRE</th>
                        <th>FECHA ENTRADA</th>
                        <th>ESTADO</th>
                        <th>SERVICIO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($citas as $cita)
                        <tr>
                            <td>{{ $cita->Nombre }}</td>
                            <td>{{ \Carbon\Carbon::parse($cita->Fecha_entrada)->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="estado-badge estado-{{ strtolower($cita->Estado) }}">
                                    {{ $cita->Estado }}
                                </span>
                            </td>
                            <td>{{ $cita->Servicio }}</td>
                            <td>
                                <a href="{{ route('cliente.citas.edit', $cita->IDcita) }}" class="btn-warning">✏️
                                    Editar</a>
                                <a href="{{ route('cliente.citas.pdf', $cita->IDcita) }}" class="btn-warning2"
                                    target="_blank">🖨️ Imprimir</a>
                                <a href="{{ route('cliente.factura.excel', $cita->IDcita) }}" class="btn-warning3"
                                    target="_blank">Excel</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="no-data">No hay citas registradas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
