<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans">

<div class="max-w-6xl mx-auto mt-8 bg-white shadow-xl rounded-xl p-8">
    <a href="{{ route('admin.citas.index') }}">
        <button type="button" class="text-blue-600 font-semibold hover:underline mb-4">
            ← Volver a Citas
        </button>
    </a>

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800 border-b-2 border-blue-500 pb-1">Inventario</h1>
        <span class="text-sm font-bold text-slate-600">Administrador
            <i class="fa-solid fa-user ml-1"></i>
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
               class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </form>

    {{-- Botones --}}
    <div class="flex gap-3 mb-6 flex-wrap">
        <a href="{{ route('admin.inventario.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold text-sm">
            <i class="fa-solid fa-plus mr-1"></i> Nuevo producto
        </a>
        <a href="{{ route('admin.inventario.movimiento_stock') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-semibold text-sm">
            <i class="fa-solid fa-arrows-rotate mr-1"></i> Movimiento de stock
        </a>
        <a href="{{ route('admin.proveedors.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold text-sm">
            <i class="fa-solid fa-user-plus mr-1"></i> Nuevo proveedor
        </a>
    </div>

    {{-- Tabla de inventario --}}
    <div class="overflow-x-auto rounded-lg border border-slate-200">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-800 text-white uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Stock</th>
                    <th class="px-4 py-3">Precio Unitario</th>
                    <th class="px-4 py-3">Proveedor</th>
                    <th class="px-4 py-3">Descripción</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($items as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-mono text-slate-500">{{ $item->idinventario }}</td>
                        <td class="px-4 py-3 font-semibold">{{ $item->nombre }}</td>
                        <td class="px-4 py-3">{{ $item->stock }}</td>
                        <td class="px-4 py-3">${{ number_format($item->precio_unitario, 2) }}</td>
                        <td class="px-4 py-3">{{ $item->nombre_proveedor }}</td>
                        <td class="px-4 py-3" style="max-width: 250px; word-wrap: break-word;">
                            {{ $item->descripcion }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.inventario.edit', $item->idinventario) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs font-semibold">
                                   <i class="fa-solid fa-pen"></i> Editar
                                </a>
                                <a href="{{ route('admin.inventario.delete', $item->idinventario) }}"
                                   class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold">
                                   <i class="fa-solid fa-trash"></i> Eliminar
                                </a>

                                <a href="{{ route('admin.inventario.toggle', $item->idinventario) }}"
   class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-xs font-semibold">

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
<div class="max-w-6xl mx-auto mt-8 bg-white shadow-xl rounded-xl p-8">
    <h2 class="text-2xl font-bold text-slate-800 border-b-2 border-blue-500 pb-1 mb-6">Proveedores</h2>

    <div class="overflow-x-auto rounded-lg border border-slate-200">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-800 text-white uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Contacto</th>
                    <th class="px-4 py-3">Teléfono</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Dirección</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($proveedores as $proveedor)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-mono text-slate-500">{{ $proveedor->id }}</td>
                        <td class="px-4 py-3 font-semibold">{{ $proveedor->nombre }}</td>
                        <td class="px-4 py-3">{{ $proveedor->contacto }}</td>
                        <td class="px-4 py-3">{{ $proveedor->telefono }}</td>
                        <td class="px-4 py-3">{{ $proveedor->email }}</td>
                        <td class="px-4 py-3">{{ $proveedor->direccion }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.proveedors.edit', $proveedor->id) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs font-semibold">
                                   <i class="fa-solid fa-pen"></i> Editar
                                </a>
                               <a href="{{ route('admin.proveedors.delete', $proveedor->id) }}"
   class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold">
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
