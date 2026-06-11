@extends('layouts.app')

@section('title', 'Inicio - Dr. Wilson Montenegro')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
@endsection
@section('content')
<h1 class="title3">BIENVENIDO</h1>
<h2 class="title3">Dr. Wilson Montenegro
    Odontología General y Especializada</h2>
    <section class="seccion-inicio">
    <div class="inicio-box">
        <div class="inicio-text">
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
<div class="mapa">
<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m11!1m3!1d3!2d-74.0949084!3d4.705575700000001!2m2!1f0!2f90!3m2!1i1024!2i768!4f75!3m3!1m2!1s0x8e3f9b9adf4e5a7d%3A0xcbb42c1a23d04b57!2sDr.%20Wilson%20Montenegro%20Odontolog%C3%ADa%20General%20y%20Especializada!4v1781038536693" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
@endsection
