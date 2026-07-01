<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cita;
use App\Models\Cliente;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Exports\FacturaExport;
use Maatwebsite\Excel\Facades\Excel;

/**
 * AdminCitaController
 * CRUD completo de citas para el rol Administrador.
 *
 * Origen: citas.php (vista) + lógica PHP interna del mismo archivo.
 */
class AdminCitaController extends Controller

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

// ── Facturas con Excel
public function generarExcel($id)
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

// ── Listar citas con búsqueda ─────────────────────────────────────
    public function index(Request $request)
{
    $user = Auth::user();
    $search = trim($request->get('search', ''));

    // No permitir búsquedas solo numéricas
    if (!empty($search) && is_numeric($search)) {
        return redirect()->route('admin.citas.index')
            ->with('error', 'Solo se puede buscar por nombre, estado o servicio.');
    }

    $like = "%{$search}%";

    $citas = DB::select("
        SELECT c.IDcita,
            u.ID,
            u.name AS Nombre,
            u.Email,
            c.Fecha_entrada,
            c.Fecha_salida,
            c.Estado,
            c.IDcliente,
            c.IDservicio,
            s.Nombre AS Servicio
        FROM Cita c
        INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
        INNER JOIN users u ON cl.ID = u.ID
        LEFT JOIN Servicio s ON c.IDservicio = s.IDservicio
        WHERE u.rol = 'cliente'
        AND (
        u.name LIKE ?
             OR u.Email LIKE ?
            OR s.Nombre LIKE ?
            OR c.Estado LIKE ?
            )
        ORDER BY c.Fecha_entrada DESC
    ", [$like, $like, $like, $like]);

    $cliente = DB::select("
        SELECT cl.IDcliente,
        u.name AS Nombre,
        u.Email
        FROM Cliente cl
        INNER JOIN users u ON cl.ID = u.ID
        WHERE u.rol = 'cliente'
        ORDER BY u.name ASC
    ");

    $servicios = DB::select("
        SELECT IDservicio, Nombre
        FROM Servicio
        ORDER BY Nombre ASC
    ");

    return view('admin.citas', compact('citas', 'cliente', 'search', 'servicios'));
}
    // ── Agendar nueva cita ───────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'fechaEntrada' => 'required|date',
            'fechaSalida'  => 'required|date',
            'idservicio' => 'required|integer',
            'idcliente'    => 'required|integer',
            'estado'       => 'required|string',
        ]);

        // 1. Fecha no puede ser pasada
        if (Carbon::parse($request->fechaEntrada)->lt(now())) {
            return redirect()->route('admin.citas.index')
             ->with('error', 'No es posible agendar una cita en una fecha pasada.');
        }

        // 2. Salida no puede ser igual ni anterior a entrada
        if (Carbon::parse($request->fechaSalida)->lte(Carbon::parse($request->fechaEntrada))) {
            return redirect()->route('admin.citas.index')
                ->with('error', 'La fecha y hora de salida debe ser posterior a la de entrada.');
        }
        // 3. Validar horario laboral (06:00 AM - 08:00 PM)
        $horaEntrada = Carbon::parse($request->fechaEntrada)->format('H:i');
        $horaSalida = Carbon::parse($request->fechaSalida)->format('H:i');

        if ($horaEntrada < '06:00' || $horaEntrada > '20:00' ||
            $horaSalida < '06:00' || $horaSalida > '20:00') {

            return redirect()->route('admin.citas.index')
                ->with('error', 'Las citas solo pueden agendarse dentro del horario laboral (06:00 AM a 08:00 PM).');
        }

        $conflicto = $this->verificarSolapamiento($request->fechaEntrada, $request->fechaSalida);
        if ($conflicto) {
            return redirect()->route('admin.citas.index')
                ->with('error', "Esta hora está ocupada. Disponible desde: " .
                    Carbon::parse($conflicto)->format('d/m/Y H:i'));
        }

        DB::insert("
            INSERT INTO Cita (Fecha_entrada, Fecha_salida, IDservicio, Estado, IDcliente)
            VALUES (?, ?, ?, ?, ?)
        ", [$request->fechaEntrada, $request->fechaSalida, $request->idservicio, $request->estado, $request->idcliente]);

        return redirect()->route('admin.citas.index')->with('success', 'Cita agendada correctamente.');
    }

    // ── Mostrar formulario de edición ────────────────────────────────────
    public function edit($id)
    {
        $citas = DB::select("
            SELECT c.IDcita AS IDcita,
                u.ID,
                u.name AS Nombre,
                u.Email,
                c.Fecha_entrada AS Fecha_entrada,
                c.Fecha_salida AS Fecha_salida,
                c.Estado AS Estado,
                s.Nombre AS Servicio,
                c.IDservicio,
                c.IDcliente
            FROM Cita c
            INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
            INNER JOIN users u ON cl.ID = u.ID
            LEFT JOIN Servicio s ON c.IDservicio = s.IDservicio
            ORDER BY c.Fecha_entrada DESC
        ");

        $cliente = DB::select("
            SELECT cl.IDcliente,
            u.name AS Nombre,
            u.Email
            FROM Cliente cl
            INNER JOIN users u ON cl.ID = u.ID
            WHERE u.rol = 'cliente'
            ORDER BY u.name ASC
        ");

        $servicios = DB::select("
            SELECT IDservicio, Nombre
            FROM Servicio
            ORDER BY Nombre ASC
        ");

        $citaEditar = DB::selectOne("
            SELECT c.IDcita AS IDcita, c.Fecha_entrada AS Fecha_entrada,
                   c.Fecha_salida AS Fecha_salida, c.Estado AS Estado,
                   c.IDservicio AS IDservicio, c.IDcliente AS IDcliente, u.name AS Nombre, u.Email
            FROM Cita c
            INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
            INNER JOIN users u  ON cl.ID = u.ID
            WHERE c.IDcita = ?
        ", [$id]);

        if (!$citaEditar) abort(404);

        return view('admin.citas', compact('citas', 'cliente', 'servicios', 'citaEditar'))->with('search', '');
    }

    // ── Guardar cambios ──────────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $request->validate([
            'fechaEntrada' => 'required|date',
            'fechaSalida'  => 'required|date',
            'idservicio'   => 'required|integer',
            'idcliente'    => 'required|integer',
            'estado'       => 'required|string',
        ]);

        // 1. Fecha de entrada no puede ser pasada
    if (Carbon::parse($request->fechaEntrada)->lt(now())) {
        return redirect()->route('admin.citas.index')
            ->with('error', 'No es posible editar una cita con una fecha y hora pasada.');
    }

    // 2. Salida no puede ser igual ni anterior a entrada
    if (Carbon::parse($request->fechaSalida)->lte(Carbon::parse($request->fechaEntrada))) {
        return redirect()->route('admin.citas.index')
            ->with('error', 'La fecha y hora de salida debe ser posterior a la de entrada.');
    }

    // 3. Validar horario laboral (06:00 AM - 08:00 PM)
        $horaEntrada = Carbon::parse($request->fechaEntrada)->format('H:i');
        $horaSalida = Carbon::parse($request->fechaSalida)->format('H:i');

        if ($horaEntrada < '06:00' || $horaEntrada > '20:00' ||
            $horaSalida < '06:00' || $horaSalida > '20:00') {

            return redirect()->route('admin.citas.index')
                ->with('error', 'Las citas solo pueden agendarse dentro del horario laboral (06:00 AM a 08:00 PM).');
        }

        $conflicto = $this->verificarSolapamiento($request->fechaEntrada, $request->fechaSalida, $id);
        if ($conflicto) {
            return redirect()->route('admin.citas.index')
                ->with('error', "Esta hora está ocupada. Disponible desde: " .
                    Carbon::parse($conflicto)->format('d/m/Y H:i'));
        }

        DB::update("
            UPDATE Cita
            SET Fecha_entrada=?, Fecha_salida=?, Estado=?, IDservicio=?, IDcliente=?
            WHERE IDcita=?
        ", [$request->fechaEntrada, $request->fechaSalida, $request->estado, $request->idservicio, $request->idcliente, $id]);

        return redirect()->route('admin.citas.index')->with('success', 'Cita actualizada correctamente.');
    }

    // ── Eliminar cita ────────────────────────────────────────────────────
    public function destroy($id)
    {
        DB::delete("DELETE FROM Cita WHERE IDcita = ?", [$id]);
        return redirect()->route('admin.citas.index')->with('success', 'Cita eliminada correctamente.');
    }

    private function getCitas(): array
    {
        return DB::select("
            SELECT c.IDcita,
                u.ID,
                u.name AS Nombre,
                u.Email,
                c.Fecha_entrada,
                c.Fecha_salida,
                c.Estado,
                c.IDservicio,
                s.Nombre AS Servicio
            FROM Cita c
            INNER JOIN Cliente cl ON c.IDcliente = cl.IDcliente
            INNER JOIN users u ON cl.ID = u.ID
            LEFT JOIN Servicio s ON c.IDservicio = s.IDservicio
            ORDER BY c.Fecha_entrada DESC
        ");
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
