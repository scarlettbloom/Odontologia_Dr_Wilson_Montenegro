<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Venta;
use App\Models\MovimientoStock;

class ClienteVentaController extends Controller
{
    // Inventario para el cliente
    public function index()
    {
        $productos = Inventario::all();
        return view('cliente.inventario', compact('productos'));
    }

    // Añadir producto al carrito (sesión)
    public function addToCart($id)
    {
        $producto = Inventario::find($id);

        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += 1;
        } else {
            $carrito[$id] = [
                'id'       => $producto->idinventario,
                'nombre'   => $producto->nombre,
                'precio'   => $producto->precio_unitario,
                'cantidad' => 1,
            ];
        }

        session()->put('carrito', $carrito);

        return redirect()->route('cliente.carrito.ver');
    }

    // Ver carrito
    public function verCarrito()
    {
        $carrito = session()->get('carrito', []);
        return view('cliente.carrito', compact('carrito'));
    }

    // Vista de checkout (datos del cliente)
    public function checkout(Request $request)
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('cliente.carrito.ver')->with('error', 'Tu carrito está vacío.');
        }

        return view('cliente.checkout', compact('carrito'));
    }

    // Guardar la compra
    public function store(Request $request)
{
    $request->validate([
        'nombre'      => 'required',
        'telefono'    => 'required',
        'direccion'   => 'required',
        'metodo_pago' => 'required',
        'descuento'   => 'nullable|numeric|min:0'
    ]);

    $carrito = session()->get('carrito', []);

    if (empty($carrito)) {
        return redirect()->route('cliente.carrito.ver')->with('error', 'Tu carrito está vacío.');
    }

    $subtotalGeneral = 0;

    // Calcular subtotal y validar stock
    foreach ($carrito as $item) {
        $producto = Inventario::find($item['id']);

        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        if ($item['cantidad'] > $producto->stock) {
            return redirect()->back()->with('error', 'No hay suficiente stock de ' . $producto->nombre . '.');
        }

        $subtotalGeneral += $producto->precio_unitario * $item['cantidad'];
    }

    // Aplicar descuento
    $descuento = floatval($request->descuento ?? 0);
    $totalGeneral = max($subtotalGeneral - $descuento, 0);

    // Registrar venta y movimiento de stock
    foreach ($carrito as $item) {
        $producto = Inventario::find($item['id']);

        Venta::create([
            'producto_id'       => $producto->idinventario,
            'cantidad'          => $item['cantidad'],
            'subtotal'          => $producto->precio_unitario * $item['cantidad'],
            'descuento'         => $descuento,
            'total'             => $totalGeneral,
            'cliente_nombre'    => $request->nombre,
            'cliente_telefono'  => $request->telefono,
            'cliente_direccion' => $request->direccion,
            'metodo_pago'       => $request->metodo_pago,
        ]);

        // Actualizar stock
        $producto->stock -= $item['cantidad'];
        $producto->save();

        MovimientoStock::create([
            'producto_id' => $producto->idinventario,
            'tipo'        => 'salida',
            'cantidad'    => $item['cantidad'],
            'descripcion' => 'Venta cliente',
            'responsable' => $request->nombre,
        ]);
    }

    // Vaciar carrito
    session()->forget('carrito');

    return redirect()->route('cliente.compras')->with('success', 'Compra realizada correctamente.');
}

    // Historial de compras del cliente
    public function compras()
    {
        $ventas = Venta::with('producto')->orderBy('created_at', 'desc')->get();
        return view('cliente.compras', compact('ventas'));
    }

    
public function carritoInventario($id)
{
    $producto = Inventario::find($id);

    if (!$producto) {
        return redirect()->back()->with('error', 'Producto no encontrado.');
    }

    // Carrito viejo (vista cliente/inventario/carrito.blade.php)
    return view('cliente.inventario.carrito', compact('producto'));
}


}
