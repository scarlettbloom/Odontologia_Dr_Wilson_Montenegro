<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>

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
        <span class="font-bold text-slate-700 text-sm">Empleado <i class="fa-solid fa-user ml-1"></i></span>
    </header>

    <main class="p-12">
        <h2 class="titulo-form">Editar producto</h2>

        <form action="{{ route('empleado.inventario.update', $item->idinventario) }}" method="POST" class="max-w-2xl mx-auto space-y-8">
            @csrf
            @method('PUT')

            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Nombre del producto:</label>
                <input type="text" name="nombre" value="{{ old('nombre', $item->nombre) }}" class="input-line w-full">
                @error('nombre') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Stock:</label>
                <input type="number" name="stock" value="{{ old('stock', $item->stock) }}" class="input-line w-32">
                @error('stock') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Precio unitario:</label>
                <input type="number" name="precio_unitario" value="{{ old('precio_unitario', $item->precio_unitario) }}" step="0.01" class="input-line w-full">
                @error('precio_unitario') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Nombre proveedor:</label>
                <input type="text" name="nombre_proveedor" value="{{ old('nombre_proveedor', $item->nombre_proveedor) }}" class="input-line w-full">
                @error('nombre_proveedor') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Descripción del producto:</label>
                <textarea name="descripcion" rows="4" class="input-line w-full">{{ $item->descripcion }}</textarea>
                @error('descripcion') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-center space-x-6 pt-10">
                <button type="submit" class="btn-actualizar">Actualizar</button>
                <a href="{{ route('empleado.inventario.index') }}" class="btn-cancelar">Cancelar</a>
            </div>

        </form>
    </main>
</div>

</body>
</html>
