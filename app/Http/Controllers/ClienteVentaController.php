<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Venta;
use App\Models\MovimientoStock;

class ClienteVentaController extends Controller
{
    public function index()
    {
        $productos = Inventario::all();
        return view('cliente.inventario', compact('productos'));
    }

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

        return redirect()->route('cliente.carrito.ver')->with('success', 'Producto agregado al carrito.');
    }

    public function verCarrito()
    {
        $carrito = session()->get('carrito', []);
        $total = collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']);

        return view('cliente.carrito', compact('carrito', 'total'));
    }

    public function eliminarDelCarrito($id)
    {
        $carrito = session()->get('carrito', []);
        unset($carrito[$id]);
        session()->put('carrito', $carrito);

        return redirect()->route('cliente.carrito.ver')->with('success', 'Producto eliminado del carrito.');
    }

    public function checkout(Request $request)
    {
        $seleccionados = explode(',', $request->productos_seleccionados);
        $carrito = session()->get('carrito', []);

        $productosAComprar = array_filter($carrito, function ($item) use ($seleccionados) {
            return in_array($item['id'], $seleccionados);
        });

        if (empty($productosAComprar)) {
            return redirect()->route('cliente.carrito.ver')->with('error', 'No seleccionaste productos para comprar.');
        }

        $request->validate([
            'nombre'      => 'required',
            'telefono'    => 'required',
            'direccion'   => 'required',
            'metodo_pago' => 'required',
        ]);

        foreach ($productosAComprar as $item) {

            $producto = Inventario::find($item['id']);

            if (!$producto) {
                return redirect()->back()->with('error', 'Producto no encontrado.');
            }

            if ($item['cantidad'] > $producto->stock) {
                return redirect()->back()->with('error', 'No hay suficiente stock de ' . $producto->nombre . '.');
            }

            // REGISTRAR VENTA
            Venta::create([
                'producto_id' => $producto->idinventario,
                'cantidad'    => $item['cantidad'],
                'subtotal'    => $producto->precio_unitario * $item['cantidad'],
                'descuento'   => 0,
                'total'       => $producto->precio_unitario * $item['cantidad'],
            ]);

            // DESCONTAR STOCK
            $producto->stock -= $item['cantidad'];
            $producto->ultima_actualizacion = now();
            $producto->save();

            // MOVIMIENTO DE STOCK
            MovimientoStock::create([
                'producto_id' => $producto->idinventario,
                'tipo'        => 'salida',
                'cantidad'    => $item['cantidad'],
                'descripcion' => 'Venta cliente',
                'responsable' => $request->nombre,
                'fecha'       => now(),
            ]);
        }

        $carritoRestante = array_filter($carrito, function ($item) use ($seleccionados) {
            return !in_array($item['id'], $seleccionados);
        });

        session()->put('carrito', $carritoRestante);

        return redirect()->route('cliente.compras')->with('success', 'Compra realizada correctamente.');
    }

    public function compras()
    {
        $ventas = Venta::orderBy('created_at', 'desc')->get();
        return view('cliente.compras', compact('ventas'));
    }

    public function actualizarCantidad(Request $request, $id)
    {
        $carrito = session()->get('carrito', []);
        $cantidad = $request->cantidad;

        $producto = Inventario::find($id);

        if (!$producto) {
            return back()->with('error', 'Producto no encontrado.');
        }

        if ($cantidad > $producto->stock) {
            return back()->with('error', 'No hay suficiente stock. Solo quedan ' . $producto->stock . ' unidades.');
        }

        foreach ($carrito as &$item) {
            if ($item['id'] == $id) {
                $item['cantidad'] = $cantidad;
            }
        }

        session()->put('carrito', $carrito);

        return back()->with('success', 'Cantidad actualizada.');
    }

    public function checkoutForm(Request $request)
    {
        $carrito = session()->get('carrito', []);
        $seleccionados = $request->input('productos_seleccionados', []);

        if (empty($seleccionados)) {
            return redirect()->route('cliente.carrito.ver')->with('error', 'No seleccionaste ningún producto.');
        }

        $productosAComprar = array_filter($carrito, fn($item) => in_array($item['id'], $seleccionados));

        $total = 0;
        foreach ($productosAComprar as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return view('cliente.checkout_form', compact('productosAComprar', 'total'));
    }
}
