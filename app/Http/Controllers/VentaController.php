<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    private function prefix(): string
    {
        return request()->routeIs('empleado.*') ? 'empleado' : 'admin';
    }

 // ── Reporte PDF de las Ventas ────────────────────────────────────────────
    public function generarPdf($id)
{
    $venta = Venta::with('producto')
        ->where('idventa', $id)
        ->first();

    if (!$venta) {
        abort(404);
    }

    $pdf = Pdf::loadView('pdf.venta', compact('venta'));

    return $pdf->stream('venta_'.$id.'.pdf');
}
    /**
     * Mostrar formulario para crear una nueva venta
     */
    public function create()
    {
        $productos = Inventario::all();
        return view($this->prefix() . '.ventas.create', compact('productos'));
    }

    /**
     * Mostrar la vista principal del módulo de ventas
     */
    public function index()
    {
        $productos = Inventario::all();
        return view($this->prefix() . '.ventas.index', compact('productos'));
    }

    /**
     * Guardar una nueva venta y actualizar el inventario
     */
    public function store(Request $request)
{
    $carrito = json_decode($request->carrito, true);

// Validar que el carrito NO esté vacío
if (!$carrito || count($carrito) === 0) {
    return redirect()->back()->with('error', 'No puedes guardar una venta sin productos.');
}

    $descuentoGeneral = floatval($request->descuento); // ← VIENE DEL FORMULARIO

    foreach ($carrito as $item) {

        $producto = Inventario::find($item['id']);
        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        if ($item['cantidad'] > $producto->stock) {
            return redirect()->back()->with('error', 'No hay suficiente stock de ' . $producto->nombre . '.');
        }

        // Calcular subtotal
        $subtotal = $item['precio'] * $item['cantidad'];

        // Aplicar descuento general a toda la venta
        $total = max($subtotal - $descuentoGeneral, 0);

        Venta::create([
            'producto_id' => $item['id'],
            'cantidad'    => $item['cantidad'],
            'subtotal'    => $subtotal,
            'descuento'   => $descuentoGeneral,
            'total'       => $total,
        ]);

        // Actualizar stock
        $producto->stock -= $item['cantidad'];
        $producto->save();
    }

    return redirect()->route($this->prefix() . '.ventas.index')
                     ->with('success', 'Venta registrada correctamente.');
}


    /**
     * Mostrar vista de descuentos
     */
    public function descuento()
    {
        return view($this->prefix() . '.ventas.descuento');
    }

    /**
     * Mostrar reporte de ventas
     */
    public function reporte()
{
    $ventas = Venta::with('producto')->get();
    return view($this->prefix() . '.ventas.reporte', compact('ventas'));
}


}
