<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::all();
        return view('servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('servicios.create');
    }

    public function store(Request $request)
    {
        Servicio::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'costo' => $request->costo
        ]);

        if (auth()->user()->rol === 'empleado') {
        return redirect()->route('empleado.servicios.index');
        }

        $prefix = auth()->user()->rol === 'administrador'
            ? 'admin'
            : 'empleado';

        return redirect()->route($prefix.'.servicios.index');
    }

    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);

        return view('servicios.edit', compact('servicio'));
    }

    public function update(Request $request, $id)
    {
        $servicio = Servicio::findOrFail($id);

        $servicio->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'costo' => $request->costo
        ]);

        if (auth()->user()->rol === 'empleado') {
        return redirect()->route('empleado.servicios.index');
        }

        $prefix = auth()->user()->rol === 'administrador'
            ? 'admin'
            : 'empleado';

        return redirect()->route($prefix.'.servicios.index');
    }

    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);

        $servicio->delete();

        $prefix = auth()->user()->rol === 'administrador'
            ? 'admin'
            : 'empleado';

        return redirect()->route($prefix.'.servicios.index');
    }
}
