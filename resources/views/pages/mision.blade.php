@extends('layouts.app')

@section('title', 'Misión - Dr. Wilson Montenegro')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/mision.css') }}">
@endsection

@section('content')

<section class="seccion-mision">
    <div class="mision-box">
        <div class="mision-text">
            <h1>NUESTRA MISIÓN</h1>
            <p>
                Brindar servicios odontológicos integrales de la más alta calidad,
                combinando tecnología avanzada, materiales innovadores y un enfoque
                personalizado para mejorar la salud bucal y la calidad de vida de
                nuestros pacientes. Nos comprometemos a crear sonrisas saludables
                en un ambiente profesional, cálido y confiable.
            </p>
        </div>
        <img src="{{ asset('img/mision.webp') }}" alt="Misión" class="mision-img">
    </div>
</section>

@endsection
