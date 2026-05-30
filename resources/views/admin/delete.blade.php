<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Producto</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .input-line { border:none; border-bottom:2px solid #cbd5e1; border-radius:0; padding-left:0; }
    </style>
</head>
<body class="bg-slate-50 font-sans">

<div class="max-w-5xl mx-auto mt-8 bg-white shadow-xl rounded-xl overflow-hidden border border-slate-200">

    {{-- Header --}}
    <header class="flex items-center justify-between px-8 py-4 bg-white border-b border-slate-100">
        <a href="{{ route('inventario.index') }}" class="text-slate-600 hover:text-blue-600 font-medium flex items-center">
            <i class="fa-solid fa-chevron-left mr-2"></i> Volver
        </a>

        <div class="inline-flex bg-slate-100 p-1.5 rounded-xl border border-slate-200 shadow-sm">
            <span class="px-6 py-2.5 text-slate-400 font-semibold text-sm opacity-50 cursor-not-allowed">Agregar</span>
            <span class="px-6 py-2.5 text-slate-400 font-semibold text-sm opacity-50 cursor-not-allowed">Editar</span>
            <span class="px-6 py-2.5 bg-red-500 text-white rounded-lg font-semibold text-sm shadow">Eliminar</span>
        </div>

        <span class="font-bold text-slate-700 text-sm">Administrador <i class="fa-solid fa-user ml-1"></i></span>
    </header>

    <main class="p-12">
        <h2 class="text-2xl font-bold text-center text-slate-800 mb-2">Eliminar producto</h2>
        <p class="text-center text-slate-400 text-sm mb-10">Revisa los datos antes de confirmar la eliminación</p>

        {{-- Datos del producto (solo lectura) --}}
        <div class="max-w-2xl mx-auto space-y-6 mb-10">
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">ID del producto:</label>
                <input type="text" value="{{ $item->idinventario }}" disabled
                       class="input-line w-full bg-transparent text-lg text-slate-400 cursor-not-allowed">
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Nombre del producto:</label>
                <input type="text" value="{{ $item->nombre }}" disabled
                       class="input-line w-full bg-transparent text-lg text-slate-400 cursor-not-allowed">
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Stock:</label>
                <input type="text" value="{{ $item->stock }}" disabled
                       class="input-line w-32 bg-transparent text-lg text-slate-400 cursor-not-allowed">
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Precio unitario:</label>
                <input type="text" value="${{ number_format($item->precio_unitario, 2) }}" disabled
                       class="input-line w-full bg-transparent text-lg text-slate-400 cursor-not-allowed">
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Nombre proveedor:</label>
                <input type="text" value="{{ $item->nombre_proveedor }}" disabled
                       class="input-line w-full bg-transparent text-lg text-slate-400 cursor-not-allowed">
            </div>
        </div>

        {{-- Alerta de confirmación --}}
        <div class="max-w-2xl mx-auto bg-red-50 border border-red-200 rounded-xl p-6 mb-8 flex items-start gap-4">
            <i class="fa-solid fa-triangle-exclamation text-red-500 text-2xl mt-1"></i>
            <div>
                <p class="font-bold text-red-700 mb-1">¿Estás seguro?</p>
                <p class="text-red-500 text-sm">Vas a eliminar este producto. Esta acción no se puede deshacer.</p>
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-center space-x-6">
            <form action="{{ route('inventario.destroy', $item->idinventario) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-40 bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-lg shadow-lg transition-all active:scale-95">
                    <i class="fa-solid fa-trash mr-1"></i> Eliminar
                </button>
            </form>
            <a href="{{ route('inventario.index') }}"
               class="w-40 bg-white border-2 border-slate-800 text-slate-800 font-bold py-3 rounded-lg text-center hover:bg-slate-50 transition-all active:scale-95">
                Cancelar
            </a>
        </div>
    </main>
</div>

</body>
</html>