@extends('layouts.inicio_sesion')

@section('title', 'Usuarios - Administrador')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">
@endsection
@section('content')

    <a href="{{ route('admin.citas.index') }}" class="btn-volver">
        Volver
    </a>

<div class="container">

    <div class="header">
        <h1>ADMINISTRADOR</h1>
        <h2>Gestión de Usuarios</h2>
    </div>

    <!-- FORMULARIO -->

    <div class="form-section">

        <h2 class="list-title">
            {{ isset($usuarioEditar) ? '✏️ Editar Usuario' : '➕ Registrar Usuario' }}
        </h2>

        <form method="POST"
              action="{{ isset($usuarioEditar)
                        ? route('admin.usuarios.update', $usuarioEditar->id)
                        : route('admin.usuarios.store') }}">

            @csrf

            @if(isset($usuarioEditar))
                @method('PUT')
            @endif

            <table class="form-table">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Contraseña</th>
                    <th>Acción</th>
                </tr>

                <tr>

                    <td>
                        <input
                            type="text"
                            name="name"
                            required
                            value="{{ old('name', $usuarioEditar->name ?? '') }}">
                    </td>

                    <td>
                        <input
                            type="email"
                            name="email"
                            required
                            value="{{ old('email', $usuarioEditar->email ?? '') }}">
                    </td>

                    <td>
                        <input
                            type="text"
                            name="telefono"
                            pattern="[0-9]{10}"
                            maxlength="10"
                            minlength="10"
                            required
                            title="Debe contener exactamente 10 dígitos"
                            value="{{ old('telefono', $usuarioEditar->telefono ?? '') }}">
                    </td>

                    <td>
                        <select name="rol" required>

                            <option value="administrador"
                                {{ isset($usuarioEditar) && $usuarioEditar->rol == 'administrador' ? 'selected' : '' }}>
                                Administrador
                            </option>

                            <option value="empleado"
                                {{ isset($usuarioEditar) && $usuarioEditar->rol == 'empleado' ? 'selected' : '' }}>
                                Empleado
                            </option>

                            <option value="cliente"
                                {{ isset($usuarioEditar) && $usuarioEditar->rol == 'cliente' ? 'selected' : '' }}>
                                Cliente
                            </option>

                        </select>
                    </td>

                    <td>
                        <input
                            type="password"
                            name="password"
                            {{ isset($usuarioEditar) ? '' : 'required' }}
                            placeholder="{{ isset($usuarioEditar) ? 'Dejar vacío para conservar' : 'Contraseña' }}">
                    </td>

                    <td>

                        @if(isset($usuarioEditar))

                            <button type="submit" class="btn-agendar">
                                💾 Guardar
                            </button>

                            <a href="{{ route('admin.usuarios.index') }}"
                               class="btn-cancelar">
                                ❌ Cancelar
                            </a>

                        @else

                            <button type="submit" class="btn-agendar">
                                Registrar
                            </button>

                        @endif

                    </td>

                </tr>
            </table>

        </form>

    </div>

    <!-- BUSCADOR -->

    <div class="search-bar">

        <form method="GET"
              action="{{ route('admin.usuarios.index') }}">

            <input
                type="text"
                name="search"
                placeholder="Buscar por nombre, correo, teléfono o rol..."
                value="{{ request('search') }}">

            <button type="submit">
                Buscar
            </button>

        </form>

    </div>

    <!-- MENSAJES -->

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <!-- TABLA -->

    <div class="table-section">

        <h2 class="list-title">
            👥 Lista de Usuarios
        </h2>

        <table class="data-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>EMAIL</th>
                    <th>TELÉFONO</th>
                    <th>ROL</th>
                    <th>FECHA REGISTRO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>

            <tbody>

                @forelse($usuarios as $usuario)

                    <tr>

                        <td>{{ $usuario->id }}</td>

                        <td>{{ $usuario->name }}</td>

                        <td>{{ $usuario->email }}</td>

                        <td>{{ $usuario->telefono ?? 'N/A' }}</td>

                        <td>

                            <span class="estado-badge estado-{{ strtolower($usuario->rol) }}">
                                {{ ucfirst($usuario->rol) }}
                            </span>

                        </td>

                        <td>

                            {{ \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y') }}

                        </td>

                        <td>

                            <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
                               class="btn-warning">
                                ✏️ Editar
                            </a>

                            <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}"
                                  method="POST"
                                  style="display:inline;"
                                  onsubmit="return confirm('¿Desea eliminar este usuario?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn-danger">
                                    🗑️ Eliminar
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="no-data">
                            No hay usuarios registrados
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
@endsection