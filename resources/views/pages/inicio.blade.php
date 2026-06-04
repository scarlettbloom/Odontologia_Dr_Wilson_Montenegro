@extends('layouts.app')

@section('title', 'Inicio - Dr. Wilson Montenegro')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
@endsection
@section('content')
<h1 class="title3">BIENVENIDO</h1>
<h2 class="title3">Dr. Wilson Montenegro
    Odontología General y Especializada</h2>
    <section class="seccion-mision">
    <div class="mision-box">
        <div class="mision-text">
            <h1>Introduccion</h1>
            <p>
            Luce la mejor sonrisa con Dr. Wilson Montenegro. Si quieres tener esa sonrisa que siempre has deseado, en
            <strong>Dr. Wilson Montenegro Odontología General y Especializada</strong>
            podemos ayudarte.</p>
            </p>
        </div>
        <img src="{{ asset('img/clinica.png') }}" alt="Misión" class="mision-img">
    </div>
</section>

@endsection
