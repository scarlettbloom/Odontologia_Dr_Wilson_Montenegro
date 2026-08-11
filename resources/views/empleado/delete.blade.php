<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Producto</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS del módulo inventario empleado -->
    <link rel="stylesheet" href="{{ asset('css/modulo_inventario_empleado.css') }}">
</head>

<body class="bg-slate-50 font-sans">

<div class="card-container">

    <header class="header-admin">
        <a href="{{ route('empleado.inventario.index') }}" class="text-slate-600 hover:text-blue-600 font-medium flex items-center">
            <i class="fa-solid fa-chevron-left mr-2"></i> Volver
        </a>

        <div class="nav-actions">
            <span class="nav-disabled">Agregar</span>
            <span class="nav-disabled">Editar</span>
            <span class="nav-active">Eliminar</span>
        </div>

        <span class="font-bold text-slate-700 text-sm">Empleado <i class="fa-solid fa-user ml-1"></i></span>
    </header>

    <main class="p-12">
        <h2 class="titulo-form">Eliminar producto</h2>
        <p class="subtitulo-form">Revisa los datos antes de confirmar la eliminación</p>

        <div class="max-w-2xl mx-auto space-y-6 mb-10">

            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">ID del producto:</label>
                <input type="text" value="{{ $item->idinventario }}" disabled class="input-line w-full">
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Nombre del producto:</label>
                <input type="text" value="{{ $item->nombre }}" disabled class="input-line w-full">
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Stock:</label>
                <input type="text" value="{{ $item->stock }}" disabled class="input-line w-32">
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Precio unitario:</label>
                <input type="text" value="${{ number_format($item->precio_unitario, 2) }}" disabled class="input-line w-full">
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Nombre proveedor:</label>
                <input type="text" value="{{ $item->nombre_proveedor }}" disabled class="input-line w-full">
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Descripción del producto:</label>
                <textarea rows="4" disabled class="input-line w-full">{{ $item->descripcion }}</textarea>
            </div>

        </div>

        <div class="alert-delete">
            <i class="fa-solid fa-triangle-exclamation alert-delete-icon"></i>
            <div>
                <p class="alert-delete-title">¿Estás seguro?</p>
                <p class="alert-delete-text">Vas a eliminar este producto. Esta acción no se puede deshacer.</p>
            </div>
        </div>

        <div class="flex justify-center space-x-6">
            <form action="{{ route('empleado.inventario.destroy', $item->idinventario) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-eliminar">
                    <i class="fa-solid fa-trash mr-1"></i> Eliminar
                </button>
            </form>

            <a href="{{ route('empleado.inventario.index') }}" class="btn-cancelar">
                Cancelar
            </a>
        </div>

    </main>
</div>

</body>
</html>


