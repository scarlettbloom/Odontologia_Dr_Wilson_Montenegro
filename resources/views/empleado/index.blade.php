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
<a href="{{ route('empleado.citas.index') }}">
    <button type="button" class="btn-volver">
        ← Volver a Citas
    </button>
</a>
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800 border-b-2 border-blue-500 pb-1">Inventario</h1>
        <span class="text-sm font-bold text-slate-600">Empleado
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
    <form method="GET" action="{{ route('inventario.index') }}" class="mb-4">
        <input type="text" name="buscar" value="{{ request('buscar') }}"
               placeholder="Filtrar por nombre o proveedor..."
               class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </form>

    {{-- Botones --}}
    <div class="flex gap-3 mb-6 flex-wrap">
        <a href="{{ route('inventario.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold text-sm">
            <i class="fa-solid fa-plus mr-1"></i> Nuevo producto
        </a>
        <a href="{{ route('inventario.movimientostock') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-semibold text-sm">
            <i class="fa-solid fa-arrows-rotate mr-1"></i> Movimiento de stock
        </a>
    </div>
 //tabla//
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
                </td> <!-- ✅ Aquí se muestra la descripción -->
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('inventario.edit', $item->idinventario) }}"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs font-semibold">
                            <i class="fa-solid fa-pen"></i> Editar
                        </a>
                        <a href="{{ route('inventario.delete', $item->idinventario) }}"
                           class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold">
                            <i class="fa-solid fa-trash"></i> Eliminar
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
</body>
</html>