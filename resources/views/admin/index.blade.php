<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS del módulo de ventas -->
    <link rel="stylesheet" href="{{ asset('css/modulo_inventario.css') }}">
</head>

<body class="bg-slate-100 font-sans">

<div class="inventario-container">

    <a href="{{ route('admin.citas.index') }}" class="btn-volver">
        ← Volver a Citas
    </a>

    {{-- Header --}}
    <div class="inventario-header">
        <h1 class="inventario-title">Inventario</h1>
        <span class="text-sm font-bold text-slate-600">
            Administrador <i class="fa-solid fa-user ml-1"></i>
        </span>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Buscador --}}
    <form method="GET" action="{{ route('admin.inventario.index') }}" class="mb-4">
        <input type="text" name="buscar" value="{{ request('buscar') }}"
               placeholder="Filtrar por nombre o proveedor..."
               class="buscador-input">
    </form>

    {{-- Botones --}}
    <div class="flex gap-3 mb-6 flex-wrap">
        <a href="{{ route('admin.inventario.create') }}" class="btn-top btn-top-blue">
            <i class="fa-solid fa-plus mr-1"></i> Nuevo producto
        </a>

        <a href="{{ route('admin.inventario.movimiento_stock') }}" class="btn-top btn-top-purple">
            <i class="fa-solid fa-arrows-rotate mr-1"></i> Movimiento de stock
        </a>

        <a href="{{ route('admin.proveedors.create') }}" class="btn-top btn-top-green">
            <i class="fa-solid fa-user-plus mr-1"></i> Nuevo proveedor
        </a>
    </div>

    {{-- Tabla de inventario --}}
    <div class="table-container">
        <table class="w-full text-sm text-left">
            <thead class="table-header">
                <tr>
                    <th class="table-cell">ID</th>
                    <th class="table-cell">Nombre</th>
                    <th class="table-cell">Stock</th>
                    <th class="table-cell">Precio Unitario</th>
                    <th class="table-cell">Proveedor</th>
                    <th class="table-cell">Descripción</th>
                    <th class="table-cell text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse($items as $item)

                    <tr class="hover:bg-slate-50 {{ $item->estado === 'inactivo' ? 'fila-inactiva' : '' }}">
                        <td class="table-cell font-mono text-slate-500">{{ $item->idinventario }}</td>
                        <td class="table-cell font-semibold">{{ $item->nombre }}</td>
                        <td class="table-cell">{{ $item->stock }}</td>
                        <td class="table-cell">${{ number_format($item->precio_unitario, 2) }}</td>
                        <td class="table-cell">{{ $item->nombre_proveedor }}</td>

                        <td class="table-cell table-description">
                            {{ $item->descripcion }}
                        </td>

                        <td class="table-cell text-center">
                            <div class="flex justify-center gap-2">

                                {{-- EDITAR --}}
                                <a href="{{ route('admin.inventario.edit', $item->idinventario) }}"
                                   class="{{ $item->estado === 'inactivo'
                                            ? 'btn-disabled'
                                            : 'btn-accion btn-edit' }}">
                                   <i class="fa-solid fa-pen"></i> Editar
                                </a>

                                {{-- ELIMINAR --}}
                                <a href="{{ route('admin.inventario.delete', $item->idinventario) }}"
                                   class="{{ $item->estado === 'inactivo'
                                            ? 'btn-disabled'
                                            : 'btn-accion btn-delete' }}">
                                   <i class="fa-solid fa-trash"></i> Eliminar
                                </a>

                                {{-- TOGGLE --}}
                                <a href="{{ route('admin.inventario.toggle', $item->idinventario) }}"
                                   class="btn-accion btn-toggle">

                                    @if($item->estado === 'activo')
                                        <i class="fa-solid fa-ban"></i> Deshabilitar
                                    @else
                                        <i class="fa-solid fa-check"></i> Habilitar
                                    @endif

                                </a>

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-slate-400">
                            <i class="fa-solid fa-box-open text-3xl mb-2 block"></i>
                            No se encontraron productos en el inventario.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Tabla de proveedores --}}
<div class="inventario-container">
    <h2 class="proveedores-title">Proveedores</h2>

    <div class="table-container">
        <table class="w-full text-sm text-left">
            <thead class="table-header">
                <tr>
                    <th class="table-cell">ID</th>
                    <th class="table-cell">Nombre</th>
                    <th class="table-cell">Contacto</th>
                    <th class="table-cell">Teléfono</th>
                    <th class="table-cell">Email</th>
                    <th class="table-cell">Dirección</th>
                    <th class="table-cell text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @foreach($proveedores as $proveedor)
                    <tr class="hover:bg-slate-50">
                        <td class="table-cell font-mono text-slate-500">{{ $proveedor->id }}</td>
                        <td class="table-cell font-semibold">{{ $proveedor->nombre }}</td>
                        <td class="table-cell">{{ $proveedor->contacto }}</td>
                        <td class="table-cell">{{ $proveedor->telefono }}</td>
                        <td class="table-cell">{{ $proveedor->email }}</td>
                        <td class="table-cell">{{ $proveedor->direccion }}</td>

                        <td class="table-cell text-center">
                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.proveedors.edit', $proveedor->id) }}"
                                   class="btn-accion btn-edit">
                                   <i class="fa-solid fa-pen"></i> Editar
                                </a>

                                <a href="{{ route('admin.proveedors.delete', $proveedor->id) }}"
                                   class="btn-accion btn-delete">
                                   <i class="fa-solid fa-trash"></i> Eliminar
                                </a>

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>


