@extends('layouts.auth')

@section('title', 'Registrarse - Dr. Wilson Montenegro')

@section('content')
<div class="login-container">
    <h2>Registrarse</h2>

    @if ($errors->any())
        <p class="error">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="text"  name="Nombre"   placeholder="Nombre"   value="{{ old('Nombre') }}"   required>
        <input type="text"  name="Apellido" placeholder="Apellido" value="{{ old('Apellido') }}" required>
        <input type="email" name="Email"    placeholder="Correo electrónico" value="{{ old('Email') }}" required>
        <input type="tel"   name="Telefono" placeholder="Celular"
               pattern="[0-9]{10}" maxlength="10"
               title="El número debe tener exactamente 10 dígitos"
               value="{{ old('Telefono') }}" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrarse</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
</div>
@endsection
