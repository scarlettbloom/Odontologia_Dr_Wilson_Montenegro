<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .input-line { border:none; border-bottom:2px solid #cbd5e1; border-radius:0; padding-left:0; }
        .input-line:focus { outline:none; border-bottom-color:#3b82f6; box-shadow:none; }
    </style>
</head>
<body class="bg-slate-50 font-sans">

<div class="max-w-5xl mx-auto mt-8 bg-white shadow-xl rounded-xl overflow-hidden border border-slate-200">

    <header class="flex items-center justify-between px-8 py-4 bg-white border-b border-slate-100">
        <a href="{{ route('admin.inventario.index') }}" class="text-slate-600 hover:text-blue-600 font-medium flex items-center">
            <i class="fa-solid fa-chevron-left mr-2"></i> Volver
        </a>
        <span class="font-bold text-slate-700 text-sm"> Administrador<i class="fa-solid fa-user ml-1"></i></span>
    </header>

    <main class="p-12">
        <h2 class="text-2xl font-bold text-center text-slate-800 mb-10">Agregar producto</h2>

        <form action="{{ route('admin.inventario.store') }}" method="POST" class="max-w-2xl mx-auto space-y-8">
            @csrf

            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Nombre del producto:</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}"
                       class="input-line w-full bg-transparent text-lg">
                @error('nombre') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Stock:</label>
                <input type="number" name="stock" value="{{ old('stock') }}"
                       class="input-line w-32 bg-transparent text-lg">
                @error('stock') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Precio unitario:</label>
                <input type="number" name="precio_unitario" value="{{ old('precio_unitario') }}" step="0.01"
                       class="input-line w-full bg-transparent text-lg">
                @error('precio_unitario') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Nombre proveedor:</label>
                <input type="text" name="nombre_proveedor" value="{{ old('nombre_proveedor') }}"
                       class="input-line w-full bg-transparent text-lg">
                @error('nombre_proveedor') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div class="flex flex-col">
    <label class="text-sm font-semibold text-slate-500 mb-1">Descripción del producto:</label>
    <textarea name="descripcion" rows="4"
              class="input-line w-full bg-transparent text-lg">{{ old('descripcion') }}</textarea>
    @error('descripcion') 
        <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
    @enderror
</div>





            <div class="flex justify-center space-x-6 pt-10">
                <button type="submit"
                        class="w-40 bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 rounded-lg shadow-lg">
                    Guardar
                </button>
                <a href="{{ route('admin.inventario.index') }}"
                   class="w-40 bg-white border-2 border-slate-800 text-slate-800 font-bold py-3 rounded-lg text-center">
                    Cancelar
                </a>
            </div>
        </form>
    </main>
</div>
</body>
</html>