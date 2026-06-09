<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $users = User::where('email', $request->email)->first();

        // VALIDAR USUARIO Y CONTRASEÑA
        if (!$users || !Hash::check($request->password, $users->password)) {
            return back()
                ->withErrors(['email' => 'Credenciales inválidas'])
                ->withInput();
        }

        session([
            'IDusuario' => $users->id,
            'email' => $users->email,
            'Nombre' => $users->name,
            'Rol' => ucfirst($users->rol),
        ]);

        return match ($users->rol) {
            'administrador' => redirect()->route('admin.citas.index'),
            'empleado' => redirect()->route('empleado.citas.index'),
            'cliente' => redirect()->route('cliente.citas.index'),
            default => back()->withErrors([
                'email' => 'Rol desconocido. Contacta al administrador.'
            ]),
        };
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Apellido' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'Telefono' => ['required', 'regex:/^[0-9]{10}$/'],
            'password' => 'required|min:6',
        ], [
            'Telefono.regex' => 'El número de teléfono debe tener exactamente 10 dígitos.',
            'Email.unique' => 'Ya existe una cuenta con ese correo.',
        ]);

        // ENCRIPTAR CONTRASEÑA
        $hashedPassword = Hash::make($request->password);

        $users = User::create([
            'name' => trim($request->Nombre . ' ' . $request->Apellido),
            'email' => $request->email,
            'telefono' => $request->Telefono,
            'password' => $hashedPassword,
            'rol' => 'cliente',
        ]);

        Cliente::create([
            'id' => $users->id
        ]);

        return redirect()
            ->route('login')
            ->with('mensaje', 'Registro exitoso, ahora puedes iniciar sesión.');
    }

    public function logout(Request $request)
    {
        session()->flush();

        return redirect()->route('login');
    }
}