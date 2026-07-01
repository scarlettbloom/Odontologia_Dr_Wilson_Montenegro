<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Models\Inventario;



class ProveedorController extends Controller
{
    /**
     * Mostrar listado de proveedores.
     */
   public function index()
{
    $items = Inventario::all();
    $proveedores = Proveedor::all();

    return view('admin.index', compact('items', 'proveedores'));
}

    /**
     * Mostrar formulario para crear un proveedor.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Guardar un nuevo proveedor.
     */
  public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'contacto' => 'nullable|string|max:255',
        'telefono' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'direccion' => 'nullable|string|max:255',
    ]);

    Proveedor::create($request->all());

    // Recupera los productos y proveedores para mostrar ambos
    $items = Inventario::all();
    $proveedores = Proveedor::all();

    return view('admin.index', compact('items', 'proveedores'))
        ->with('success', 'Proveedor creado correctamente');
}


    /**
     * Mostrar un proveedor específico.
     */
    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.show', compact('proveedor'));
    }

    /**
     * Mostrar formulario para editar un proveedor.
     */
    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.edit', compact('proveedor'));
    }

    /**
     * Actualizar un proveedor.
     */
    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:proveedors,nombre,' . $proveedor->id,
            'contacto' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:255',
        ]);

        $proveedor->update($request->all());

        return redirect()->route('admin.proveedors.index')
            ->with('success', 'Proveedor actualizado correctamente');
    }

    /**
     * Eliminar un proveedor.
     */
    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('admin.proveedors.index')
            ->with('success', 'Proveedor eliminado correctamente');
    }

 public function confirmDelete($id)
{
    $proveedor = Proveedor::findOrFail($id);
    return view('proveedores.delete', compact('proveedor'));
}

}

