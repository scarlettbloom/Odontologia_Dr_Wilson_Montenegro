<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * ClienteCitaController
 * El cliente puede agendar y editar sus citas (sin eliminar, sin cambiar estado).
 * Las citas siempre quedan en estado Pendiente hasta confirmación del admin.
 *
 * Origen: Citacliente.php
 */
class ClienteCitaController extends Controller
{
    // ── Reporte PDF de las citas ────────────────────────────────────────────
    public function generarPdf($id)
{
    $cita = DB::selectOne("
        SELECT
            c.IDcita,
            c.Fecha_entrada,
            c.Fecha_salida,
            c.Estado,
            c.IDservicio,

            u.Name AS NombrePaciente,
            u.Email,

            s.Nombre AS Servicio,
            s.Costo AS Precio

        FROM Cita c
        INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
        INNER JOIN Users u ON cl.ID = u.ID
        LEFT JOIN Servicio s ON c.IDservicio = s.IDservicio

        WHERE c.IDcita = ?
    ", [$id]);

    if (!$cita) {
        abort(404);
    }

    $pdf = Pdf::loadView('pdf.cita', compact('cita'));

    return $pdf->stream('cita_'.$id.'.pdf');
}

    // ── Listar todas las citas ────────────────────────────────────────────
    public function index()
{
    $userId = session('IDusuario');

    $citas = DB::select("
        SELECT c.IDcita,
            u.ID,
            u.Email,
            c.Fecha_entrada,
            c.Fecha_salida,
            c.Estado,
            c.IDservicio,
            s.Nombre AS Servicio
        FROM Cita c
        INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
        INNER JOIN Users u ON cl.ID = u.ID
        LEFT JOIN Servicio s ON c.IDservicio = s.IDservicio
        WHERE u.ID = ?
        ORDER BY c.Fecha_entrada DESC
    ", [$userId]);

    $servicios = DB::select("
        SELECT IDservicio, Nombre
        FROM Servicio
        ORDER BY Nombre ASC
    ");

    return view('cliente.citas', compact('citas', 'servicios'));
}

    // ── Agendar nueva cita ────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'fechaEntrada' => 'required|date',
            'fechaSalida'  => 'required|date',
            'idservicio'   => 'required|integer',
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

        $userId = session('IDusuario');

        $cliente = DB::selectOne("
            SELECT IDcliente
            FROM Cliente
            WHERE ID = ?
        ", [$userId]);

        if (!$cliente) {
            return redirect()->route('cliente.citas.index')
                ->with('error', 'Cliente no encontrado.');
        }

        $conflicto = $this->verificarSolapamiento($request->fechaEntrada, $request->fechaSalida);
        if ($conflicto) {
            return redirect()->route('cliente.citas.index')
                ->with('error', 'Esta hora está ocupada. Disponible desde: ' .
                    Carbon::parse($conflicto)->format('d/m/Y H:i'));
        }

        DB::insert("
            INSERT INTO Cita (Fecha_entrada, Fecha_salida, Estado, IDservicio, IDcliente)
            VALUES (?, ?, 'Pendiente', ?, ?)
        ", [$request->fechaEntrada, $request->fechaSalida, $request->idservicio, $cliente->IDcliente]);

        return redirect()->route('cliente.citas.index')
            ->with('success', 'Cita agendada correctamente (queda en Pendiente hasta confirmación del administrador).');
    }

    // ── Mostrar formulario de edición ─────────────────────────────────────
    public function edit($id)
    {
        $citas = $this->getCitas();
        
        $servicios = DB::select("
            SELECT IDservicio, Nombre
            FROM Servicio
            ORDER BY Nombre ASC
        ");

        $citaEditar = DB::selectOne("
            SELECT IDcita AS IDcita, Fecha_entrada AS Fecha_entrada,
                   Fecha_salida AS Fecha_salida, Estado AS Estado,
                   IDservicio AS IDservicio, IDcliente AS IDcliente
            FROM Cita
            WHERE IDcita = ?
        ", [$id]);
        if (!$citaEditar) abort(404);

        $userId = session('IDusuario');

        $propietario = DB::selectOne("
            SELECT u.ID
            FROM Cita c
            INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
            INNER JOIN Users u ON cl.ID = u.ID
            WHERE c.IDcita = ?
        ", [$id]);

        if (!$propietario || $propietario->ID != $userId) {
            abort(403);
}

        return view('cliente.citas', compact('citas', 'citaEditar', 'servicios'));
    }

    // ── Guardar cambios ───────────────────────────────────────────────────
    public function update(Request $request, $id)
{
    $request->validate([
        'fechaEntrada' => 'required|date',
        'fechaSalida'  => 'required|date',  // quitado after:fechaEntrada
        'idservicio'   => 'required|integer',
    ]);

    $userId = session('IDusuario');

    $propietario = DB::selectOne("
        SELECT u.ID
        FROM Cita c
        INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
        INNER JOIN Users u ON cl.ID = u.ID
        WHERE c.IDcita = ?
    ", [$id]);

    if (!$propietario || $propietario->ID != $userId) {
        abort(403);
}

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
        SET Fecha_entrada=?, Fecha_salida=?, Estado='Pendiente', IDservicio=?
        WHERE IDcita=?
    ", [$request->fechaEntrada, $request->fechaSalida, $request->idservicio, $id]);

    return redirect()->route('cliente.citas.index')
        ->with('success', 'Cita actualizada correctamente (queda en Pendiente hasta confirmación del administrador).');
    }

    private function getCitas(): array
{
    $userId = session('IDusuario');

    return DB::select("
        SELECT c.IDcita,
               u.ID,
               u.Email,
               c.Fecha_entrada,
               c.Fecha_salida,
               c.Estado,
               c.IDservicio,
               s.Nombre AS Servicio
        FROM Cita c
        INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
        INNER JOIN Users u ON cl.ID = u.ID
        LEFT JOIN Servicio s ON c.IDservicio = s.IDservicio
        WHERE u.ID = ?
        ORDER BY c.Fecha_entrada DESC
    ", [$userId]);
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
