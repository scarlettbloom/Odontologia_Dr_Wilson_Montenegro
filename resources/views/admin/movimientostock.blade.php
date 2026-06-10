<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos de Stock</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-100 min-h-screen font-sans">

<div class="max-w-5xl mx-auto mt-10 px-4">

    {{-- Header --}}
    <div class="bg-white rounded-xl shadow-md px-8 py-5 flex justify-between items-center mb-6 border border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">
                <i class="fa-solid fa-arrows-rotate text-purple-600 mr-2"></i>
                Movimientos de Stock
            </h1>
            <p class="text-slate-400 text-sm mt-1">Historial de entradas y salidas del inventario</p>
        </div>
        <a href="{{ route('inventario.index') }}"
           class="flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition-all active:scale-95">
            <i class="fa-solid fa-chevron-left"></i> Volver
        </a>
    </div>

    {{-- Tarjetas resumen --}}
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-green-200 shadow-sm px-6 py-4 flex items-center gap-4">
            <div class="bg-green-100 text-green-600 rounded-full w-12 h-12 flex items-center justify-center text-xl">
                <i class="fa-solid fa-arrow-down"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase">Total Entradas</p>
                <p class="text-2xl font-bold text-green-600">+10000</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-red-200 shadow-sm px-6 py-4 flex items-center gap-4">
            <div class="bg-red-100 text-red-500 rounded-full w-12 h-12 flex items-center justify-center text-xl">
                <i class="fa-solid fa-arrow-up"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase">Total Salidas</p>
                <p class="text-2xl font-bold text-red-500">-2</p>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-semibold text-slate-700 text-sm uppercase tracking-wide">
                <i class="fa-solid fa-list mr-1 text-slate-400"></i> Registro de movimientos
            </h2>
            <span class="text-xs text-slate-400">2 registros</span>
        </div>

        <table class="w-full text-sm text-left">
            <thead class="bg-slate-800 text-white text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4"><i class="fa-regular fa-calendar mr-1"></i> Fecha</th>
                    <th class="px-6 py-4"><i class="fa-solid fa-box mr-1"></i> Producto</th>
                    <th class="px-6 py-4"><i class="fa-solid fa-tag mr-1"></i> Tipo</th>
                    <th class="px-6 py-4"><i class="fa-solid fa-hashtag mr-1"></i> Cantidad</th>
                    <th class="px-6 py-4"><i class="fa-solid fa-user mr-1"></i> Responsable</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">

                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 text-slate-500 font-mono text-xs">25/05/2026</td>
                    <td class="px-6 py-4 font-semibold text-slate-800">Mascarillas</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fa-solid fa-circle-arrow-down text-xs"></i> Entrada
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold text-green-600">+10</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">A</div>
                            Admin
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 text-slate-500 font-mono text-xs">26/05/2026</td>
                    <td class="px-6 py-4 font-semibold text-slate-800">Mascarillas</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fa-solid fa-circle-arrow-up text-xs"></i> Salida
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold text-red-500">-2</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">J</div>
                            Juan
                        </span>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>
</div>

</body>
</html>
