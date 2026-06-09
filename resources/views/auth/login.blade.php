@extends('layouts.auth')

@section('title', 'Iniciar Sesión - Dr. Wilson Montenegro')
<div>
@section('content')
<div class="login-container">
    <h2>Iniciar Sesión</h2>

    @if ($errors->any())
        <p class="error">{{ $errors->first() }}</p>
    @endif

    @if (session('mensaje'))
        <p style="color:green; margin-bottom:15px;">{{ session('mensaje') }}</p>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>

    <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
</div>
@endsection
