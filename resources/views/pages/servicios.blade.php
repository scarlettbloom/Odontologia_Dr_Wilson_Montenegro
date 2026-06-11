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

@endsection
