<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Proveedor</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .input-line { 
            border:none; 
            border-bottom:2px solid #cbd5e1; 
            border-radius:0; 
            padding-left:0; 
        }
        .input-line:focus { 
            outline:none; 
            border-bottom-color:#3b82f6; 
            box-shadow:none; 
        }
    </style>
</head>

<body class="bg-slate-50 font-sans">

<div class="max-w-5xl mx-auto mt-8 bg-white shadow-xl rounded-xl overflow-hidden border border-slate-200">

    {{-- Header --}}
    <header class="flex items-center justify-between px-8 py-4 bg-white border-b border-slate-100">
        <a href="{{ route('admin.inventario.index') }}" 
           class="text-slate-600 hover:text-blue-600 font-medium flex items-center">
            <i class="fa-solid fa-chevron-left mr-2"></i> Volver
        </a>

        <span class="font-bold text-slate-700 text-sm">
            Administrador <i class="fa-solid fa-user ml-1"></i>
        </span>
    </header>

    {{-- Main --}}
    <main class="p-12">
        <h2 class="text-2xl font-bold text-center text-slate-800 mb-10">
            Editar proveedor
        </h2>

        <form action="{{ route('admin.proveedors.update', $proveedor->id) }}" 
              method="POST" 
              class="max-w-2xl mx-auto space-y-8">

            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Nombre del proveedor:</label>
                <input type="text" name="nombre" 
                       value="{{ old('nombre', $proveedor->nombre) }}"
                       class="input-line w-full bg-transparent text-lg">
                @error('nombre') 
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Contacto --}}
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Nombre de contacto:</label>
                <input type="text" name="contacto" 
                       value="{{ old('contacto', $proveedor->contacto) }}"
                       class="input-line w-full bg-transparent text-lg">
                @error('contacto') 
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Teléfono --}}
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Teléfono:</label>
                <input type="text" name="telefono" 
                       value="{{ old('telefono', $proveedor->telefono) }}"
                       class="input-line w-full bg-transparent text-lg">
                @error('telefono') 
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Email --}}
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Correo electrónico:</label>
                <input type="email" name="email" 
                       value="{{ old('email', $proveedor->email) }}"
                       class="input-line w-full bg-transparent text-lg">
                @error('email') 
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Dirección --}}
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-slate-500 mb-1">Dirección:</label>
                <textarea name="direccion" rows="3"
                          class="input-line w-full bg-transparent text-lg">{{ old('direccion', $proveedor->direccion) }}</textarea>
                @error('direccion') 
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Botones --}}
            <div class="flex justify-center space-x-6 pt-10">
                <button type="submit"
                        class="w-40 bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 rounded-lg shadow-lg">
                    Actualizar
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
