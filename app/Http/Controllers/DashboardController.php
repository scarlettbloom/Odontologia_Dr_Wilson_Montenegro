<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $anio = (int) ($request->anio ?? date('Y'));
        $mes  = $request->filled('mes') ? (int) $request->mes : null;

        if ($mes < 1 || $mes > 12) {
            $mes = null;
        }

        $citas = DB::table('cita')
            ->whereYear('fecha_entrada', $anio);

        if ($mes) {
            $citas->whereMonth('fecha_entrada', $mes);
        }

        $totalCitas = (clone $citas)->count();

        $pendientes = (clone $citas)
            ->whereRaw('LOWER(estado) = ?', ['pendiente'])
            ->count();

        $atendidas = (clone $citas)
            ->whereRaw('LOWER(estado) = ?', ['atendida'])
            ->count();

        $canceladas = (clone $citas)
            ->whereRaw('LOWER(estado) = ?', ['cancelada'])
            ->count();

        $ingresosMes = DB::table('cita as c')
            ->join('servicio as s', 'c.idservicio', '=', 's.idservicio')
            ->whereYear('c.fecha_entrada', $anio)
            ->whereRaw('LOWER(c.estado) = ?', ['atendida'])
            ->when($mes, function ($query) use ($mes) {
                $query->whereMonth('c.fecha_entrada', $mes);
            })
            ->sum('s.costo');

        return view('dashboard.index', compact(
            'totalCitas',
            'pendientes',
            'atendidas',
            'canceladas',
            'ingresosMes',
            'anio',
            'mes'
        ));
    }
}
