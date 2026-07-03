<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Exports\FacturaExport;
use Maatwebsite\Excel\Facades\Excel;

/**
 * EmpleadoCitaController
 * Gestión de citas para el rol Empleado (puede agendar, editar y eliminar).
 *
 * Origen: empleado.php
 */
class EmpleadoCitaController extends Controller
{

 // ── Reporte PDF de las citas ────────────────────────────────────────────
    public function generarPdf($id)
{
    $cita = DB::selectOne("
        SELECT
            c.IDcita,
            c.Fecha_entrada,
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

// ── Facturas con Excel
public function generarExcel($id)
{

    $cita = DB::selectOne("

        SELECT

            c.IDcita,

            c.Fecha_entrada,

            c.Estado,

            c.IDservicio,

            u.Name AS NombrePaciente,

            u.Email,

            s.Nombre AS Servicio,

            s.Costo AS Precio

        FROM Cita c

        INNER JOIN Cliente cl
        ON c.IDcliente = cl.IDcliente

        INNER JOIN Users u
        ON cl.ID = u.ID

        LEFT JOIN Servicio s
        ON c.IDservicio = s.IDservicio

        WHERE c.IDcita = ?

    ",[$id]);


    if(!$cita)
    {
        abort(404);
    }


    return Excel::download(

        new FacturaExport($cita),

        'Factura_'.$id.'.xlsx'

    );

}

    // ── Listar citas con búsqueda ─────────────────────────────────────────
    public function index(Request $request)
{
    $user = Auth::user();
    $search = $request->get('search', '');

    // Validar que no sean solo números
    if (!empty($search) && is_numeric($search)) {
        return redirect()->route('empleado.citas.index')
            ->with('error', 'Solo se puede buscar por nombre, estado o servicio.');
    }

    $like   = "%{$search}%";

    $citas = DB::select("
    SELECT c.IDcita AS IDcita,
       u.ID,
       u.name AS Nombre,
       u.Email,
       c.Fecha_entrada AS Fecha_entrada,
       c.Estado AS Estado,
       s.Nombre AS Servicio,
       c.IDservicio
    FROM Cita c
    INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
    INNER JOIN users u ON cl.ID = u.ID
    LEFT JOIN Servicio s ON c.IDservicio = s.IDservicio
    WHERE CAST(u.ID AS CHAR) LIKE ?
       OR u.name LIKE ?
       OR s.Nombre LIKE ?
       OR c.Estado LIKE ?
    ORDER BY c.Fecha_entrada DESC
    ", [$like, $like, $like, $like]);

    $cliente = DB::select("
        SELECT cl.IDcliente, u.name AS Nombre
        FROM Cliente cl
        INNER JOIN users u ON cl.ID = u.ID
        WHERE u.rol = 'cliente'
        ORDER BY u.Email ASC
    ");

    $servicios = DB::select("
        SELECT IDservicio, Nombre
        FROM Servicio
        ORDER BY Nombre ASC
    ");

    return view('empleado.citas',compact('citas', 'search', 'cliente', 'servicios'));
}

    // ── Agendar nueva cita ───────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
        'fechaEntrada' => 'required|date',
        'idservicio' => 'required|integer',
        'idcliente'    => 'required|integer',
        'estado'       => 'required|string',
        ]);

        $fechaSalida = $this->calcularFechaSalida($request->fechaEntrada);

        // 1. Fecha no puede ser pasada
        if (Carbon::parse($request->fechaEntrada)->lt(now())) {
            return redirect()->route('empleado.citas.index')
             ->with('error', 'No es posible agendar una cita en una fecha pasada.');
        }

        // 2. Validar horario laboral (06:00 AM - 08:00 PM)
        $horaEntrada = Carbon::parse($request->fechaEntrada)->format('H:i');
        $horaSalida = Carbon::parse($fechaSalida)->format('H:i');

        if ($horaEntrada < '06:00' || $horaEntrada > '20:00' ||
            $horaSalida < '06:00' || $horaSalida > '20:00') {

            return redirect()->route('empleado.citas.index')
                ->with('error', 'Las citas solo pueden agendarse dentro del horario laboral (06:00 AM a 08:00 PM).');
        }

        $conflicto = $this->verificarSolapamiento($request->fechaEntrada, $fechaSalida);
        if ($conflicto) {
            return redirect()->route('empleado.citas.index')
                ->with('error', 'Esta hora está ocupada. Disponible desde: ' .
                    Carbon::parse($conflicto)->format('d/m/Y H:i'));
        }

        DB::insert("
            INSERT INTO Cita (Fecha_entrada, Fecha_salida, IDservicio, Estado, IDcliente)
            VALUES (?, ?, ?, ?, ?)
        ", [$request->fechaEntrada, $fechaSalida, $request->idservicio, $request->estado, $request->idcliente]);

        return redirect()->route('empleado.citas.index')->with('success', 'Cita agendada correctamente.');
    }

    // ── Mostrar formulario de edición ────────────────────────────────────
    public function edit($id)
    {
    $citas = $this->getCitas();

    $cliente = DB::select("
        SELECT cl.IDcliente, u.name AS Nombre
        FROM Cliente cl
        INNER JOIN users u ON cl.ID = u.ID
        WHERE u.rol = 'cliente'
        ORDER BY u.Email ASC
    ");

    $servicios = DB::select("
        SELECT IDservicio, Nombre
        FROM Servicio
        ORDER BY Nombre ASC
    ");

    $citaEditar = DB::selectOne("
        SELECT c.IDcita,
               c.Fecha_entrada,
               c.Estado,
               c.IDservicio,
               c.IDcliente
        FROM Cita c
        WHERE c.IDcita = ?
    ", [$id]);

    if (!$citaEditar) {
        abort(404);
    }

    $search = '';

    return view('empleado.citas',compact('citas', 'citaEditar', 'search', 'cliente', 'servicios'));
    }
    // ── Guardar cambios ──────────────────────────────────────────────────
    public function update(Request $request, $id)
    {
    $request->validate([
        'fechaEntrada' => 'required|date',
        'idservicio' => 'required|integer',
        'estado'       => 'required|string',
        'idcliente'    => 'required|integer',
    ]);
    $fechaSalida = $this->calcularFechaSalida($request->fechaEntrada);
    // 1. Fecha no puede ser pasada
    if (Carbon::parse($request->fechaEntrada)->lt(now())) {
        return redirect()->route('empleado.citas.index')
            ->with('error', 'No es posible editar una cita con una fecha pasada.');
    }

    // 2. Validar horario laboral (06:00 AM - 08:00 PM)
        $horaEntrada = Carbon::parse($request->fechaEntrada)->format('H:i');
        $horaSalida = Carbon::parse($fechaSalida)->format('H:i');

        if ($horaEntrada < '06:00' || $horaEntrada > '20:00' ||
            $horaSalida < '06:00' || $horaSalida > '20:00') {

            return redirect()->route('empleado.citas.index')
                ->with('error', 'Las citas solo pueden agendarse dentro del horario laboral (06:00 AM a 08:00 PM).');
        }

    $conflicto = $this->verificarSolapamiento(
        $request->fechaEntrada,
        $fechaSalida,
        $id
    );

    if ($conflicto) {
        return redirect()->route('empleado.citas.index')
            ->with('error', 'Esta hora está ocupada. Disponible desde: ' .
                Carbon::parse($conflicto)->format('d/m/Y H:i'));
    }

    DB::update("
        UPDATE Cita
        SET Fecha_entrada = ?,
            Fecha_salida  = ?,
            IDservicio    = ?,
            Estado        = ?,
            IDcliente     = ?
        WHERE IDcita = ?
    ", [
        $request->fechaEntrada,
        $fechaSalida,
        $request->idservicio,
        $request->estado,
        $request->idcliente,
        $id
    ]);

    return redirect()->route('empleado.citas.index')
        ->with('success', 'Cita actualizada correctamente.');
    }

    // ── Eliminar cita ────────────────────────────────────────────────────
    public function destroy($id)
    {
        DB::delete("DELETE FROM Cita WHERE IDcita = ?", [$id]);
        return redirect()->route('empleado.citas.index')->with('success', 'Cita eliminada correctamente.');
    }

    private function getCitas(): array
    {
        return DB::select("
            SELECT c.IDcita AS IDcita,
               u.ID,
               u.name AS Nombre,
               u.Email,
               c.Fecha_entrada AS Fecha_entrada,
               c.Estado AS Estado,
               s.Nombre AS Servicio,
               c.IDservicio
            FROM Cita c
            INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
            INNER JOIN users u ON cl.ID = u.ID
            LEFT JOIN Servicio s ON c.IDservicio = s.IDservicio
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

    private function calcularFechaSalida(string $entrada): string
    {
        return Carbon::parse($entrada)->addHour()->format('Y-m-d H:i:s');
    }
}
