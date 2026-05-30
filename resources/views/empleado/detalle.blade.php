<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Producto</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="container mx-auto p-8">

        <div class="bg-white shadow-xl rounded-xl p-8 max-w-3xl mx-auto">

            <div class="flex justify-between items-center mb-6">

                <h1 class="text-4xl font-bold text-gray-800">
                    Detalle Producto
                </h1>

                <a href="{{ route('inventario.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">

                    Volver

                </a>

            </div>

            <div class="grid grid-cols-2 gap-6">

                <div>
                    <p class="text-gray-500 font-semibold">
                        ID
                    </p>

                    <p class="text-xl">
                        1
                    </p>
                </div>

                <div>
                    <p class="text-gray-500 font-semibold">
                        Nombre
                    </p>

                    <p class="text-xl">
                        Mascarillas
                    </p>
                </div>

                <div>
                    <p class="text-gray-500 font-semibold">
                        Precio
                    </p>

                    <p class="text-xl text-green-600 font-bold">
                        $10,0000
                    </p>
                </div>

                <div>
                    <p class="text-gray-500 font-semibold">
                        Stock Disponible
                    </p>

                    <p class="text-xl">
                        10 unidades
                    </p>
                </div>

                <div>
                    <p class="text-gray-500 font-semibold">
                        Categoría
                    </p>

                    <p class="text-xl">
                       Medicina
                    </p>
                </div>

                <div>
                    <p class="text-gray-500 font-semibold">
                        Estado
                    </p>

                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                        Disponible
                    </span>
                </div>

            </div>

        </div>

    </div>

</body>
</html>
