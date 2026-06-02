<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class ClienteController extends Controller
{
    public function productos()
    {
        $productos = Producto::all();

        return view('cliente.productos.index', compact('productos'));
    }

    public function detalle($id)
    {
        $producto = Producto::findOrFail($id);

        return view('cliente.productos.show', compact('producto'));
    }

    public function carrito()
    {
        $carrito = [];

        return view('cliente.carrito.index', compact('carrito'));
    }
}