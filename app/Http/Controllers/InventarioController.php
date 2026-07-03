<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Proveedor;

class InventarioController extends Controller
{ 
    // ============================
    // INDEX
    // ============================
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');

        $items = Inventario::when($buscar, function ($query, $buscar) {
            return $query->where('nombre', 'LIKE', "%{$buscar}%")
                         ->orWhere('nombre_proveedor', 'LIKE', "%{$buscar}%");
        })->get();

        $proveedores = Proveedor::all();
        $rol = strtolower(trim(Auth::user()->rol));

        if ($rol === 'administrador' || $rol === 'admin') {
            return view('admin.index', compact('items', 'proveedores'));
        }

        if ($rol === 'empleado') {
            return view('empleado.index', compact('items', 'proveedores'));
        }

        if ($rol === 'cliente') {
            return redirect()->route('cliente.inventario');
        }

        abort(403, 'Rol no autorizado');
    }

    // ============================
    // CREATE
    // ============================
  public function create()
{
    $rol = strtolower(trim(Auth::user()->rol));
    $proveedors = \App\Models\Proveedor::all(); // 🔹 Agregar esta línea

    if ($rol === 'administrador' || $rol === 'admin') {
        return view('admin.create', compact('proveedors')); // 🔹 Pasar a la vista
    }

    if ($rol === 'empleado') {
        return view('empleado.create', compact('proveedors'));
    }

    abort(403);
}


    // ============================
    // STORE
    // ============================
    public function store(Request $request)
    {
        $request->validate([
            'nombre'           => 'required|string|max:50',
            'stock'            => 'required|integer|min:0',
            'precio_unitario'  => 'required|numeric|min:0',
            'nombre_proveedor' => 'required|string|max:50',
            'descripcion'      => 'required|string|max:250',
        ]);

       Inventario::create([
    'nombre' => $request->nombre,
    'stock' => $request->stock,
    'precio_unitario' => $request->precio_unitario,
    'nombre_proveedor' => $request->nombre_proveedor,
    'descripcion' => $request->descripcion,
    'estado' => 'activo',
]);
        $rol = strtolower(trim(Auth::user()->rol));

        if ($rol === 'administrador' || $rol === 'admin') {
            return redirect()->route('admin.inventario.index')
                             ->with('success', 'Producto agregado con éxito.');
        }

        if ($rol === 'empleado') {
            return redirect()->route('empleado.inventario.index')
                             ->with('success', 'Producto agregado con éxito.');
        }

        abort(403);
    }

    // ============================
    // EDIT
    // ============================
    public function edit($id)
    {
        $item = Inventario::findOrFail($id);

        // 🔒 Bloquear edición si está inactivo
        if ($item->estado === 'inactivo') {
            return redirect()->back()->with('error', 'Este producto está deshabilitado y no puede ser editado.');
        }

        $rol = strtolower(trim(Auth::user()->rol));
        $proveedors = Proveedor::all();

        if ($rol === 'administrador' || $rol === 'admin') {
            return view('admin.edit', compact('item', 'proveedors'));
        }

        if ($rol === 'empleado') {
            return view('empleado.edit', compact('item', 'proveedors'));
        }

        abort(403);
    }

    // ============================
    // UPDATE
    // ============================
    public function update(Request $request, $id)
    {
        $item = Inventario::findOrFail($id);

        // 🔒 Bloquear actualización si está inactivo
        if ($item->estado === 'inactivo') {
            return redirect()->back()->with('error', 'Este producto está deshabilitado y no puede ser actualizado.');
        }

        $request->validate([
            'nombre'           => 'required|string|max:50',
            'stock'            => 'required|integer|min:0',
            'precio_unitario'  => 'required|numeric|min:0',
            'nombre_proveedor' => 'required|string|max:50',
            'descripcion'      => 'required|string|max:250',
        ]);

        $item->update($request->only([
            'nombre',
            'stock',
            'precio_unitario',
            'nombre_proveedor',
            'descripcion'
        ]));

        $item->ultima_actualizacion = now();
        $item->save();

        $rol = strtolower(trim(Auth::user()->rol));

        if ($rol === 'administrador' || $rol === 'admin') {
            return redirect()->route('admin.inventario.index')
                             ->with('success', 'Producto actualizado con éxito.');
        }

        if ($rol === 'empleado') {
            return redirect()->route('empleado.inventario.index')
                             ->with('success', 'Producto actualizado con éxito.');
        }

        abort(403);
    }

    // ============================
    // DELETE
    // ============================
    public function destroy($id)
    {
        $item = Inventario::findOrFail($id);

        // 🔒 Bloquear eliminación si está inactivo
        if ($item->estado === 'inactivo') {
            return redirect()->back()->with('error', 'Este producto está deshabilitado y no puede ser eliminado.');
        }

        $item->delete();

        $rol = strtolower(trim(Auth::user()->rol));

        if ($rol === 'administrador' || $rol === 'admin') {
            return redirect()->route('admin.inventario.index')
                             ->with('success', 'Producto eliminado con éxito.');
        }

        if ($rol === 'empleado') {
            return redirect()->route('empleado.inventario.index')
                             ->with('success', 'Producto eliminado con éxito.');
        }

        abort(403);
    }

    // ============================
    // CONFIRM DELETE
    // ============================
    public function confirmDelete($id)
    {
        $item = Inventario::findOrFail($id);
        $rol = strtolower(trim(Auth::user()->rol));

        if ($rol === 'administrador' || $rol === 'admin') {
            return view('admin.delete', compact('item'));
        }

        if ($rol === 'empleado') {
            return view('empleado.delete', compact('item'));
        }

        abort(403);
    }

    // ============================
    // CLIENTE
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
        $carrito = Inventario::all();
        return view('cliente.inventario.carrito', compact('carrito'));
    }

    // ============================
    // MOVIMIENTO DE STOCK
    // ============================
    public function movimiento()
    {
        $inventario = Inventario::all();
        $rol = strtolower(trim(Auth::user()->rol));

        if ($rol === 'administrador' || $rol === 'admin') {
            return view('admin.movimiento_stock', compact('inventario'));
        }

        if ($rol === 'empleado') {
            return view('empleado.movimiento_stock', compact('inventario'));
        }

        abort(403, 'No tienes permiso para ver esta sección');
    }

    // ============================
    // CARRITO CLIENTE
    // ============================
    public function clienteCarrito($id)
    {
        $producto = Inventario::find($id);

        if (!$producto) {
            return redirect()->route('cliente.inventario')->with('error', 'Producto no encontrado.');
        }

        $carrito = session()->get('carrito', []);
        $existe = false;

        foreach ($carrito as &$item) {
            if ($item['id'] == $producto->idinventario) {
                $item['cantidad']++;
                $existe = true;
                break;
            }
        }

        if (!$existe) {
            $carrito[] = [
                'id' => $producto->idinventario,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio_unitario,
                'cantidad' => 1,
            ];
        }

        session()->put('carrito', $carrito);

        return redirect()->route('cliente.carrito.ver')->with('success', 'Producto agregado al carrito.');
    }

    // ============================
    // TOGGLE ESTADO
    // ============================
    public function toggleEstado($id)
    {
        $item = Inventario::findOrFail($id);

        $item->estado = $item->estado === 'activo' ? 'inactivo' : 'activo';
        $item->save();

        return redirect()->route('admin.inventario.index')
                         ->with('success', 'Estado del producto actualizado.');
    }
}
