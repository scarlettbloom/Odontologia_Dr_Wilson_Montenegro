<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * EmpleadoCitaController
 * Gestión de citas para el rol Empleado (puede agendar y editar, no eliminar).
 *
 * Origen: empleado.php
 */
class EmpleadoCitaController extends Controller
{

    // ── Listar citas con búsqueda ─────────────────────────────────────────
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $like   = "%{$search}%";

        $citas = DB::select("
            SELECT c.IDcita AS IDcita, u.IDusuario, u.Email,
                   c.Fecha_entrada AS Fecha_entrada, c.Fecha_salida AS Fecha_salida,
                   c.Estado AS Estado, c.Tipo AS Tipo
            FROM Cita c
            INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
            INNER JOIN Usuario u  ON cl.IDusuario = u.IDusuario
            WHERE u.IDusuario LIKE ?
               OR u.Email     LIKE ?
               OR c.Tipo      LIKE ?
               OR c.Estado    LIKE ?
               OR DATE_FORMAT(c.Fecha_entrada, '%d/%m/%Y %H:%i') LIKE ?
               OR DATE_FORMAT(c.Fecha_salida,  '%d/%m/%Y %H:%i') LIKE ?
            ORDER BY c.Fecha_entrada DESC
        ", [$like, $like, $like, $like, $like, $like]);

        return view('empleado.citas', compact('citas', 'search'));
    }

    // ── Agendar nueva cita ───────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'fechaEntrada' => 'required|date',
            'fechaSalida'  => 'required|date|after:fechaEntrada',
            'tipo'         => 'required|string',
            'correo'       => 'required|email',
        ]);

        $cliente = DB::selectOne("
            SELECT cl.IDcliente
            FROM Cliente cl
            INNER JOIN Usuario u ON cl.IDusuario = u.IDusuario
            WHERE u.Email = ? LIMIT 1
        ", [$request->correo]);

        if (!$cliente) {
            return redirect()->route('empleado.citas.index')
                ->with('error', 'No existe un cliente con el correo ingresado.');
        }

        $conflicto = $this->verificarSolapamiento($request->fechaEntrada, $request->fechaSalida);
        if ($conflicto) {
            return redirect()->route('empleado.citas.index')
                ->with('error', 'Esta hora está ocupada. Disponible desde: ' .
                    Carbon::parse($conflicto)->format('d/m/Y H:i'));
        }

        DB::insert("
            INSERT INTO Cita (Fecha_entrada, Fecha_salida, Estado, Tipo, IDcliente)
            VALUES (?, ?, 'Pendiente', ?, ?)
        ", [$request->fechaEntrada, $request->fechaSalida, $request->tipo, $cliente->IDcliente]);

        return redirect()->route('empleado.citas.index')->with('success', 'Cita agendada correctamente.');
    }

    // ── Mostrar formulario de edición ────────────────────────────────────
    public function edit($id)
    {
        $citas      = $this->getCitas();
        $citaEditar = DB::selectOne("
            SELECT IDcita AS IDcita, Fecha_entrada AS Fecha_entrada,
                   Fecha_salida AS Fecha_salida, Estado AS Estado,
                   Tipo AS Tipo, IDcliente AS IDcliente
            FROM Cita
            WHERE IDcita = ?
        ", [$id]);
        if (!$citaEditar) abort(404);

        $search = '';
        return view('empleado.citas', compact('citas', 'citaEditar', 'search'));
    }

    // ── Guardar cambios ──────────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $request->validate([
            'fechaEntrada' => 'required|date',
            'fechaSalida'  => 'required|date|after:fechaEntrada',
            'tipo'         => 'required|string',
        ]);

        $conflicto = $this->verificarSolapamiento($request->fechaEntrada, $request->fechaSalida, $id);
        if ($conflicto) {
            return redirect()->route('empleado.citas.index')
                ->with('error', 'Esta hora está ocupada. Disponible desde: ' .
                    Carbon::parse($conflicto)->format('d/m/Y H:i'));
        }

        DB::update("
            UPDATE Cita
            SET Fecha_entrada=?, Fecha_salida=?, Estado='Pendiente', Tipo=?
            WHERE IDcita=?
        ", [$request->fechaEntrada, $request->fechaSalida, $request->tipo, $id]);

        return redirect()->route('empleado.citas.index')->with('success', 'Cita actualizada correctamente.');
    }

    private function getCitas(): array
    {
        return DB::select("
            SELECT c.IDcita AS IDcita, u.IDusuario, u.Email,
                   c.Fecha_entrada AS Fecha_entrada, c.Fecha_salida AS Fecha_salida,
                   c.Estado AS Estado, c.Tipo AS Tipo
            FROM Cita c
            INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
            INNER JOIN Usuario u  ON cl.IDusuario = u.IDusuario
            ORDER BY c.Fecha_entrada DESC
        ");
    }

    private function verificarSolapamiento(string $entrada, string $salida, ?int $excluirId = null): ?string
    {
        if ($excluirId) {
            $row = DB::selectOne("
                SELECT MAX(Fecha_salida) AS disponible_desde
                FROM Cita
                WHERE IDcita <> ? AND (? < Fecha_salida) AND (? > Fecha_entrada)
            ", [$excluirId, $entrada, $salida]);
        } else {
            $row = DB::selectOne("
                SELECT MAX(Fecha_salida) AS disponible_desde
                FROM Cita
                WHERE (? < Fecha_salida) AND (? > Fecha_entrada)
            ", [$entrada, $salida]);
        }
        return $row->disponible_desde ?? null;
    }
}
