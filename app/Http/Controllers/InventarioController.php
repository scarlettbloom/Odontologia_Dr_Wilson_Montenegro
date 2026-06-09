<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');

        $items = Inventario::when($buscar, function ($query, $buscar) {
            return $query->where('nombre', 'LIKE', "%{$buscar}%")
                         ->orWhere('nombre_proveedor', 'LIKE', "%{$buscar}%");
        })->get();

        $rol = session('Rol');

        if ($rol == 'Administrador') {
            return view('admin.index', compact('items'));
        }

        if ($rol == 'Empleado') {
            return view('empleado.index', compact('items'));
        }

        if ($rol == 'Cliente') {
            return redirect()->route('cliente.inventario');
        }

        abort(403, 'Rol no autorizado');
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'           => 'required|string|max:50',
            'stock'            => 'required|integer|min:0',
            'precio_unitario'  => 'required|numeric|min:0',
            'nombre_proveedor' => 'required|string|max:50',
        ]);

        Inventario::create($request->only([
            'nombre',
            'stock',
            'precio_unitario',
            'nombre_proveedor'
        ]));

        return redirect()->route('inventario.index')
                         ->with('success', 'Producto agregado con éxito.');
    }

    public function edit($id)
    {
        $item = Inventario::findOrFail($id);
        return view('admin.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Inventario::findOrFail($id);

        $request->validate([
            'nombre'           => 'required|string|max:50',
            'stock'            => 'required|integer|min:0',
            'precio_unitario'  => 'required|numeric|min:0',
            'nombre_proveedor' => 'required|string|max:50',
        ]);

        $item->update($request->only([
            'nombre',
            'stock',
            'precio_unitario',
            'nombre_proveedor'
        ]));

        return redirect()->route('inventario.index')
                         ->with('success', 'Producto actualizado con éxito.');
    }

    public function destroy($id)
    {
        $item = Inventario::findOrFail($id);
        $item->delete();

        return redirect()->route('inventario.index')
                         ->with('success', 'Producto eliminado con éxito.');
    }

    public function confirmDelete($id)
    {
        $item = Inventario::findOrFail($id);
        return view('admin.delete', compact('item'));
    }

    // ============================
    //  VISTAS PARA EL CLIENTE
    // ============================

    public function clienteIndex()
    {
        $productos = Inventario::all();
        return view('cliente.inventario.index', compact('productos'));
    }

    public function clienteShow($id)
    {
        $producto = Inventario::findOrFail($id);
        return view('cliente.inventario.show', compact('producto'));
    }

public function carrito()
{
    // Por ahora solo mostramos algunos productos como ejemplo
    $carrito = Inventario::all();
    return view('cliente.inventario.carrito', compact('carrito'));
}

}
