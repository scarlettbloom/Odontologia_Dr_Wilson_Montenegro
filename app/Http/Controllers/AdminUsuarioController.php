<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUsuarioController extends Controller
{
    // ── Listar usuarios con búsqueda ─────────────────────────────────────
    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));

        $like = "%{$search}%";

        $usuarios = DB::select("
            SELECT
                id,
                name,
                email,
                telefono,
                rol,
                created_at
            FROM users
            WHERE name LIKE ?
               OR email LIKE ?
               OR telefono LIKE ?
               OR rol LIKE ?
            ORDER BY id DESC
        ", [$like, $like, $like, $like]);

        return view('admin.usuarios', compact(
            'usuarios',
            'search'
        ));
    }

    // ── Crear usuario ────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'telefono'  => 'required|digits:10',
            'rol'       => 'required|in:administrador,empleado,cliente',
            'password'  => 'required|min:6',
        ]);

        DB::insert("
            INSERT INTO users
            (
                name,
                email,
                telefono,
                rol,
                password,
                created_at,
                updated_at
            )
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())
        ", [
            $request->name,
            $request->email,
            $request->telefono,
            $request->rol,
            Hash::make($request->password)
        ]);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario registrado correctamente.');
    }

    // ── Mostrar formulario edición ──────────────────────────────────────
    public function edit($id)
    {
        $usuarios = DB::select("
            SELECT
                id,
                name,
                email,
                telefono,
                rol,
                created_at
            FROM users
            ORDER BY id DESC
        ");

        $usuarioEditar = DB::selectOne("
            SELECT
                id,
                name,
                email,
                telefono,
                rol
            FROM users
            WHERE id = ?
        ", [$id]);

        if (!$usuarioEditar) {
            abort(404);
        }

        return view(
            'admin.usuarios',
            compact(
                'usuarios',
                'usuarioEditar'
            )
        )->with('search', '');
    }

    // ── Actualizar usuario ───────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $id,
            'telefono'  => 'required|digits:10',
            'rol'       => 'required|in:administrador,empleado,cliente',
        ]);

        if ($request->filled('password')) {

            DB::update("
                UPDATE users
                SET
                    name = ?,
                    email = ?,
                    telefono = ?,
                    rol = ?,
                    password = ?,
                    updated_at = NOW()
                WHERE id = ?
            ", [
                $request->name,
                $request->email,
                $request->telefono,
                $request->rol,
                Hash::make($request->password),
                $id
            ]);

        } else {

            DB::update("
                UPDATE users
                SET
                    name = ?,
                    email = ?,
                    telefono = ?,
                    rol = ?,
                    updated_at = NOW()
                WHERE id = ?
            ", [
                $request->name,
                $request->email,
                $request->telefono,
                $request->rol,
                $id
            ]);
        }

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    // ── Eliminar usuario ────────────────────────────────────────────────
    public function destroy($id)
    {
        $usuario = DB::selectOne("
            SELECT id, rol
            FROM users
            WHERE id = ?
        ", [$id]);

        if (!$usuario) {
            abort(404);
        }

        if ($usuario->rol === 'administrador') {

            $cantidadAdmins = DB::selectOne("
                SELECT COUNT(*) as total
                FROM users
                WHERE rol = 'administrador'
            ");

            if ($cantidadAdmins->total <= 1) {

                return redirect()
                    ->route('admin.usuarios.index')
                    ->with(
                        'error',
                        'No se puede eliminar el único administrador del sistema.'
                    );
            }
        }

        DB::delete("
            DELETE FROM users
            WHERE id = ?
        ", [$id]);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}