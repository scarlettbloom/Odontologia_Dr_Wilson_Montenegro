<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS del módulo inventario empleado -->
    <link rel="stylesheet" href="{{ asset('css/modulo_inventario_empleado.css') }}">
</head>

<body class="bg-slate-100 font-sans">

<div class="inventario-container">

    <a href="{{ route('empleado.citas.index') }}">
        <button type="button" class="btn-volver">← Volver a Citas</button>
    </a>

    <div class="inventario-header">
        <h1 class="inventario-title">Inventario</h1>
        <span class="user-role">Empleado <i class="fa-solid fa-user ml-1"></i></span>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('empleado.inventario.index') }}">
        <input type="text" name="buscar" value="{{ request('buscar') }}"
               placeholder="Filtrar por nombre o proveedor..."
               class="search-input">
    </form>

    <div class="flex gap-3 mb-6 flex-wrap">
        <a href="{{ route('empleado.inventario.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus mr-1"></i> Nuevo producto
        </a>

        <a href="{{ route('empleado.inventario.movimiento_stock') }}" class="btn-purple">
            <i class="fa-solid fa-arrows-rotate mr-1"></i> Movimiento de stock
        </a>
    </div>

    <div class="table-container">
        <table class="table-inventario">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Stock</th>
                    <th>Precio Unitario</th>
                    <th>Proveedor</th>
                    <th>Descripción</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($items as $item)
                <tr>
                    <td class="font-mono text-slate-500">{{ $item->idinventario }}</td>
                    <td class="font-semibold">{{ $item->nombre }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>${{ number_format($item->precio_unitario, 2) }}</td>
                    <td>{{ $item->nombre_proveedor }}</td>
                    <td style="max-width: 250px; word-wrap: break-word;">
                        {{ $item->descripcion }}
                    </td>

                    <td class="text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('empleado.inventario.edit', $item->idinventario) }}" class="btn-edit">
                                <i class="fa-solid fa-pen"></i> Editar
                            </a>

                            <a href="{{ route('empleado.inventario.delete', $item->idinventario) }}" class="btn-delete">
                                <i class="fa-solid fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-message">
                        <i class="fa-solid fa-box-open"></i>
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
