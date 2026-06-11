<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Venta;
use App\Models\MovimientoStock;

class VentaController extends Controller
{
    /**
     * Mostrar formulario para crear una nueva venta
     */
    public function create()
    {
        $productos = Inventario::all();
        return view('admin.ventas.create', compact('productos'));
    }

    /**
     * Mostrar la vista principal del módulo de ventas
     */
    public function index()
    {
        $productos = Inventario::all();
        return view('admin.ventas.index', compact('productos'));
    }

    /**
     * Guardar una nueva venta y actualizar el inventario
     */
  public function store(Request $request)
{
    $carrito = json_decode($request->carrito, true);
    $descuentoTotal = floatval($request->descuento ?? 0);

    // Calcular subtotal general
    $subtotalGeneral = 0;
    foreach ($carrito as $item) {
        $subtotalGeneral += $item['precio'] * $item['cantidad'];
    }

    // Registrar cada producto con su descuento proporcional
    foreach ($carrito as $item) {

        $producto = Inventario::find($item['id']);
        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        if ($item['cantidad'] > $producto->stock) {
            return redirect()->back()->with('error', 'No hay suficiente stock de ' . $producto->nombre . '.');
        }

        // Subtotal del producto
        $subtotalProducto = $item['precio'] * $item['cantidad'];

        // Descuento proporcional
        $descuentoProducto = 0;
        if ($subtotalGeneral > 0) {
            $descuentoProducto = ($subtotalProducto / $subtotalGeneral) * $descuentoTotal;
        }

        // Total del producto
        $totalProducto = max($subtotalProducto - $descuentoProducto, 0);

        // Guardar venta
        Venta::create([
            'producto_id' => $item['id'],
            'cantidad'    => $item['cantidad'],
            'subtotal'    => $subtotalProducto,
            'descuento'   => $descuentoProducto,
            'total'       => $totalProducto,
        ]);

        // Actualizar stock
        $producto->stock -= $item['cantidad'];
        $producto->save();

        MovimientoStock::create([
            'producto_id' => $producto->idinventario,
            'tipo'        => 'salida',
            'cantidad'    => $item['cantidad'],
            'descripcion' => 'Venta registrada',
            'responsable' => auth()->user()->name ?? 'Administrador',
        ]);
    }

    return redirect()->route('admin.ventas.index')->with('success', 'Venta registrada correctamente.');
}



    /**
     * Mostrar vista de descuentos
     */
    public function descuento()
    {
        return view('admin.ventas.descuento');
    }

    /**
     * Mostrar reporte de ventas
     */
   public function reporte()
{
    $ventas = Venta::with('producto')->orderBy('created_at', 'desc')->get();
    return view('admin.ventas.reporte', compact('ventas'));
}

}
