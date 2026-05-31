<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * ClienteCitaController
 * El cliente puede agendar y editar sus citas (sin eliminar, sin cambiar estado).
 * Las citas siempre quedan en estado Pendiente hasta confirmación del admin.
 *
 * Origen: Citacliente.php
 */
class ClienteCitaController extends Controller
{
    // ── Listar todas las citas ────────────────────────────────────────────
    public function index()
    {
        $citas = DB::select("
            SELECT c.IDcita AS IDcita, u.ID, u.Email,
                   c.Fecha_entrada AS Fecha_entrada, c.Fecha_salida AS Fecha_salida,
                   c.Estado AS Estado, c.Tipo AS Tipo
            FROM Cita c
            INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
            INNER JOIN Users u  ON cl.ID = u.ID
            ORDER BY c.Fecha_entrada DESC
        ");

        return view('cliente.citas', compact('citas'));
    }

    // ── Agendar nueva cita ────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'fechaEntrada' => 'required|date',
            'fechaSalida'  => 'required|date',
            'tipo'         => 'required|string',
            'correo'       => 'required|email',
        ]);

        // 1. Fecha no puede ser pasada
        if (Carbon::parse($request->fechaEntrada)->lt(now())) {
            return redirect()->route('cliente.citas.index')
             ->with('error', 'No es posible agendar una cita en una fecha pasada.');
        }
        
        // 2. Salida no puede ser igual ni anterior a entrada
        if (Carbon::parse($request->fechaSalida)->lte(Carbon::parse($request->fechaEntrada))) {
            return redirect()->route('cliente.citas.index')
                ->with('error', 'La fecha y hora de salida debe ser posterior a la de entrada.');
        }

        $cliente = DB::selectOne("
            SELECT cl.IDcliente
            FROM Cliente cl
            INNER JOIN Users u ON cl.ID = u.ID
            WHERE u.Email = ? LIMIT 1
        ", [$request->correo]);

        if (!$cliente) {
            return redirect()->route('cliente.citas.index')
                ->with('error', 'No existe un cliente con el correo ingresado.');
        }

        $conflicto = $this->verificarSolapamiento($request->fechaEntrada, $request->fechaSalida);
        if ($conflicto) {
            return redirect()->route('cliente.citas.index')
                ->with('error', 'Esta hora está ocupada. Disponible desde: ' .
                    Carbon::parse($conflicto)->format('d/m/Y H:i'));
        }

        DB::insert("
            INSERT INTO Cita (Fecha_entrada, Fecha_salida, Estado, Tipo, IDcliente)
            VALUES (?, ?, 'Pendiente', ?, ?)
        ", [$request->fechaEntrada, $request->fechaSalida, $request->tipo, $cliente->IDcliente]);

        return redirect()->route('cliente.citas.index')
            ->with('success', 'Cita agendada correctamente (queda en Pendiente hasta confirmación del administrador).');
    }

    // ── Mostrar formulario de edición ─────────────────────────────────────
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

        return view('cliente.citas', compact('citas', 'citaEditar'));
    }

    // ── Guardar cambios ───────────────────────────────────────────────────
    public function update(Request $request, $id)
{
    $request->validate([
        'fechaEntrada' => 'required|date',
        'fechaSalida'  => 'required|date',  // quitado after:fechaEntrada
        'tipo'         => 'required|string',
    ]);

    // 1. Fecha de entrada no puede ser pasada
    if (Carbon::parse($request->fechaEntrada)->lt(now())) {
        return redirect()->route('cliente.citas.index')
            ->with('error', 'No es posible editar una cita con una fecha y hora pasada.');
    }

    // 2. Salida no puede ser igual ni anterior a entrada
    if (Carbon::parse($request->fechaSalida)->lte(Carbon::parse($request->fechaEntrada))) {
        return redirect()->route('cliente.citas.index')
            ->with('error', 'La fecha y hora de salida debe ser posterior a la de entrada.');
    }

    $conflicto = $this->verificarSolapamiento($request->fechaEntrada, $request->fechaSalida, $id);
    if ($conflicto) {
        return redirect()->route('cliente.citas.index')
            ->with('error', 'Esta hora está ocupada. Disponible desde: ' .
                Carbon::parse($conflicto)->format('d/m/Y H:i'));
    }

    DB::update("
        UPDATE Cita
        SET Fecha_entrada=?, Fecha_salida=?, Estado='Pendiente', Tipo=?
        WHERE IDcita=?
    ", [$request->fechaEntrada, $request->fechaSalida, $request->tipo, $id]);

    return redirect()->route('cliente.citas.index')
        ->with('success', 'Cita actualizada correctamente (queda en Pendiente hasta confirmación del administrador).');
    }

    private function getCitas(): array
    {
        return DB::select("
            SELECT c.IDcita AS IDcita, u.ID, u.Email,
                   c.Fecha_entrada AS Fecha_entrada, c.Fecha_salida AS Fecha_salida,
                   c.Estado AS Estado, c.Tipo AS Tipo
            FROM Cita c
            INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
            INNER JOIN Users u  ON cl.ID = u.ID
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
