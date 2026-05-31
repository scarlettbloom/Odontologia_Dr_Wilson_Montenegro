<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Usuario;
use Carbon\Carbon;

/**
 * AdminCitaController
 * CRUD completo de citas para el rol Administrador.
 *
 * Origen: citas.php (vista) + lógica PHP interna del mismo archivo.
 */
class AdminCitaController extends Controller
{   // ── Listar citas ─────────────────────────────────────────────────────
    public function index()
    {
        $citas = DB::select("
            SELECT c.IDcita AS IDcita, u.ID, u.Email,
                   c.Fecha_entrada AS Fecha_entrada, c.Fecha_salida AS Fecha_salida,
                   c.Estado AS Estado, c.Tipo AS Tipo, c.IDcliente AS IDcliente
            FROM cita c
            INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
            INNER JOIN users u  ON cl.ID = u.ID
            ORDER BY c.Fecha_entrada DESC
        ");

        $cliente = DB::select("
            SELECT cl.IDcliente, u.Email
            FROM Cliente cl
            INNER JOIN users u ON cl.ID = u.ID
            ORDER BY u.Email ASC
        ");

        return view('admin.citas', compact('citas', 'cliente'));
    }

    // ── Agendar nueva cita ───────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'fechaEntrada' => 'required|date',
            'fechaSalida'  => 'required|date',
            'tipo'         => 'required|string',
            'idcliente'    => 'required|integer',
            'estado'       => 'required|string',
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

        $conflicto = $this->verificarSolapamiento($request->fechaEntrada, $request->fechaSalida);
        if ($conflicto) {
            return redirect()->route('admin.citas.index')
                ->with('error', "Esta hora está ocupada. Disponible desde: " .
                    Carbon::parse($conflicto)->format('d/m/Y H:i'));
        }

        DB::insert("
            INSERT INTO Cita (Fecha_entrada, Fecha_salida, Tipo, Estado, IDcliente)
            VALUES (?, ?, ?, ?, ?)
        ", [$request->fechaEntrada, $request->fechaSalida, $request->tipo, $request->estado, $request->idcliente]);

        return redirect()->route('admin.citas.index')->with('success', 'Cita agendada correctamente.');
    }

    // ── Mostrar formulario de edición ────────────────────────────────────
    public function edit($id)
    {
        $citas = DB::select("
            SELECT c.IDcita AS IDcita, u.ID, u.Email,
                   c.Fecha_entrada AS Fecha_entrada, c.Fecha_salida AS Fecha_salida,
                   c.Estado AS Estado, c.Tipo AS Tipo, c.IDcliente AS IDcliente
            FROM Cita c
            INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
            INNER JOIN users u  ON cl.ID = u.ID
            ORDER BY c.Fecha_entrada DESC
        ");

        $cliente = DB::select("
            SELECT cl.IDcliente, u.Email
            FROM Cliente cl
            INNER JOIN users u ON cl.ID = u.ID
            ORDER BY u.Email ASC
        ");

        $citaEditar = DB::selectOne("
            SELECT c.IDcita AS IDcita, c.Fecha_entrada AS Fecha_entrada,
                   c.Fecha_salida AS Fecha_salida, c.Estado AS Estado,
                   c.Tipo AS Tipo, c.IDcliente AS IDcliente, u.Email
            FROM Cita c
            INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
            INNER JOIN users u  ON cl.ID = u.ID
            WHERE c.IDcita = ?
        ", [$id]);

        if (!$citaEditar) abort(404);

        return view('admin.citas', compact('citas', 'cliente', 'citaEditar'));
    }

    // ── Guardar cambios ──────────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $request->validate([
            'fechaEntrada' => 'required|date',
            'fechaSalida'  => 'required|date|after:fechaEntrada',
            'tipo'         => 'required|string',
            'idcliente'    => 'required|integer',
            'estado'       => 'required|string',
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
            return redirect()->route('admin.citas.index')
                ->with('error', "Esta hora está ocupada. Disponible desde: " .
                    Carbon::parse($conflicto)->format('d/m/Y H:i'));
        }

        DB::update("
            UPDATE Cita
            SET Fecha_entrada=?, Fecha_salida=?, Estado=?, Tipo=?, IDcliente=?
            WHERE IDcita=?
        ", [$request->fechaEntrada, $request->fechaSalida, $request->estado, $request->tipo, $request->idcliente, $id]);

        return redirect()->route('admin.citas.index')->with('success', 'Cita actualizada correctamente.');
    }

    // ── Eliminar cita ────────────────────────────────────────────────────
    public function destroy($id)
    {
        DB::delete("DELETE FROM Cita WHERE IDcita = ?", [$id]);
        return redirect()->route('admin.citas.index')->with('success', 'Cita eliminada correctamente.');
    }

    // ── Helper: verificar solapamiento de horarios ────────────────────────
    private function verificarSolapamiento(string $entrada, string $salida, ?int $excluirId = null): ?string
    {
        $sql = "SELECT MAX(Fecha_salida) AS disponible_desde
                FROM Cita
                WHERE (? < Fecha_salida) AND (? > Fecha_entrada)";
        $params = [$entrada, $salida];

        if ($excluirId) {
            $sql = "SELECT MAX(Fecha_salida) AS disponible_desde
                    FROM Cita
                    WHERE IDcita <> ? AND (? < Fecha_salida) AND (? > Fecha_entrada)";
            $params = [$excluirId, $entrada, $salida];
        }

        $row = DB::selectOne($sql, $params);
        return $row->disponible_desde ?? null;
    }
}
