@extends('layouts.app')

@section('title', 'Servicios - Dr. Wilson Montenegro')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/style-servicios.css') }}">
@endsection

@section('content')
<br>
<h1 class="title">NUESTROS SERVICIOS</h1>
<br>

<section class="serviciosuwu">
    <div class="carrusel-contenedor">

        <input type="radio" name="slide" id="s1" checked>
        <input type="radio" name="slide" id="s2">
        <input type="radio" name="slide" id="s3">

        <div class="carrusel">
            <div class="slide">
                <img src="{{ asset('img/servicio1.jpg') }}" alt="Blanqueamiento Dental">
            </div>
            <div class="slide">
                <img src="{{ asset('img/servicio2.jpg') }}" alt="Implantes Dentales">
            </div>
            <div class="slide">
                <img src="{{ asset('img/servicio3.jpg') }}" alt="Ortodoncia">
            </div>
        </div>

        <div class="navegacion">
            <label for="s1" class="bar"></label>
            <label for="s2" class="bar"></label>
            <label for="s3" class="bar"></label>
        </div>
    </div>

</section>

<br><br><br>
<section class="lista-servicios">

    <div class="servicio-card">
        <h3>🦷 Limpieza Dental</h3>
        <p>Eliminación de placa bacteriana y sarro para mantener una sonrisa saludable.</p>
        <span>$80.000 COP</span>
    </div>

    <div class="servicio-card">
        <h3>✨ Blanqueamiento Dental</h3>
        <p>Tratamiento estético para aclarar el color de los dientes y mejorar la apariencia de la sonrisa.</p>
        <span>$250.000 COP</span>
    </div>

    <div class="servicio-card">
        <h3>😁 Ortodoncia</h3>
        <p>Corrección de la posición dental mediante brackets o alineadores.</p>
        <span>Desde $1.500.000 COP</span>
    </div>

    <div class="servicio-card">
        <h3>🔧 Extracción Dental</h3>
        <p>Procedimiento seguro para retirar dientes dañados o que afectan la salud bucal.</p>
        <span>$120.000 COP</span>
    </div>

    <div class="servicio-card">
        <h3>🩺 Endodoncia</h3>
        <p>Tratamiento de conductos para eliminar infecciones y conservar el diente natural.</p>
        <span>$350.000 COP</span>
    </div>

    <div class="servicio-card">
        <h3>🦷 Implante Dental</h3>
        <p>Reemplazo permanente de dientes perdidos con implantes de alta calidad.</p>
        <span>Desde $2.000.000 COP</span>
    </div>

    <div class="servicio-card">
        <h3>😊 Diseño de Sonrisa</h3>
        <p>Mejora estética integral para obtener una sonrisa más armónica y atractiva.</p>
        <span>Desde $1.000.000 COP</span>
    </div>

    <div class="servicio-card">
        <h3>📋 Control Odontológico</h3>
        <p>Consulta preventiva para evaluar el estado de la salud oral y detectar problemas a tiempo.</p>
        <span>$60.000 COP</span>
    </div>

    <div class="servicio-card">
        <h3>📷 Radiografía Dental</h3>
        <p>Diagnóstico preciso mediante imágenes radiográficas para tratamientos odontológicos.</p>
        <span>$50.000 COP</span>
    </div>

</section>

@endsection
