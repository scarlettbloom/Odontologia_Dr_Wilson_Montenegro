@extends('layouts.app')

@section('title', 'Visión - Dr. Wilson Montenegro')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/vision.css') }}">
@endsection

@section('content')
<br>

<section class="seccion-vision">
    <div class="vision-box">
        <div class="vision-text">
            <h1>NUESTRA VISIÓN</h1>
            <p>
                Ser líderes en la transformación de sonrisas, ofreciendo tratamientos innovadores, personalizados
                y de alta calidad que promuevan la salud bucal y el bienestar de cada paciente, destacándonos
                por nuestro compromiso con la excelencia, la tecnología avanzada y la atención humana.
            </p>
        </div>
        <div class="vision-imgs">
            <img src="{{ asset('img/retenedores.jpg') }}" alt="Retenedores">
            <img src="{{ asset('img/implantes.jpg') }}" alt="Implantes">
            <img src="{{ asset('img/consultorio.webp') }}" alt="Consultorio">
        </div>
    </div>
</section>
<br><br><br><br><br>

@endsection
