@extends('layouts.inicio_sesion')

@section('content')

<style>
.btn-volver{
    display:inline-block;
    margin:20px 0 0 30px;
    background:#6c757d;
    color:white;
    padding:10px 18px;
    border-radius:8px;
    text-decoration:none;
    font-weight:bold;
}

.btn-volver:hover{
    background:#5a6268;
}

.header {
    background: #005bb5;
    color: white;
    padding: 25px;
    text-align: center;
    position: relative;
    border-radius: 10px 10px 0 0;
}

.header h1 {
    font-size: 2.5em;
    margin-bottom: 10px;
    font-weight: 300;
}

.header h2 {
    font-size: 1.5em;
    font-weight: 300;
    color: #ecf0f1;
}

.container{
    padding:5px;
}

.container2{
    max-width: 1400px;
    margin: 0 auto;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    padding: 20px;
}

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    padding:30px;
}

.card{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
    text-align:center;
    height:200px;
    width:250px;
}

.card h3{
    color:#1565c0;
    font-size:30px
}

.card h1{
    margin-top:15px;
    font-size:25px;
}

form{
    padding:60px;
    display:flex;
    justify-content:center;
    gap:10px;
    margin-bottom:25px;
    align-items:center;
    flex-wrap:wrap;
}

form select,
form button{
    padding:10px 15px;
    border-radius:8px;
    border:1px solid #ccc;
}

form button{
    background:#1565c0;
    color:white;
    border:none;
    cursor:pointer;
}

form button:hover{
    background:#0d47a1;
}

.card:nth-child(1){
    border-top:5px solid #2196f3;
}

.card:nth-child(2){
    border-top:5px solid #ff9800;
}

.card:nth-child(3){
    border-top:5px solid #4caf50;
}

.card:nth-child(4){
    border-top:5px solid #9c27b0;
}

.card:nth-child(5){
    border-top:5px solid #f44336;
}

.list-title {
    color: #005bb5;
    padding:20px;
    margin-bottom: -50px;
    text-align: center;
}

.form-section {
    background:rgb(255, 255, 255);
    padding: 10px;
    border-bottom: 3px solid #dfe4ea;
}

</style>

<a href="{{ route(request()->routeIs('empleado.*') ? 'empleado.citas.index' : 'admin.citas.index') }}" class="btn-volver">Volver</a>
@php
    $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ];
    @endphp
<div class="container2">
    <div class="header">
    <h1>
        Dashboard Administrativo

        @if($mes)
            - {{ $meses[$mes] }} {{ $anio }}
        @else
            - Año {{ $anio }}
        @endif
    </h1>
    </div>

<div class="form-section">
<h2 class="list-title">Filtrado de citas</h2>
<form method="GET">

    <select name="anio">
    @for($i = date('Y'); $i >= 2020; $i--)
        <option value="{{ $i }}" {{ ($anio ?? '') == $i ? 'selected' : '' }}>
            {{ $i }}
        </option>
    @endfor
</select>

<select name="mes">
    <option value="">Todo el año</option>

    @foreach($meses as $numero => $nombre)
        <option value="{{ $numero }}" {{ ($mes ?? '') == $numero ? 'selected' : '' }}>
            {{ $nombre }}
        </option>
    @endforeach
</select>

    <button type="submit">
        Filtrar
    </button>
  
</form>
</div>

<div class="container">

    <div class="cards">

        <div class="card">
            <h3>Total Citas</h3>
            <h1>{{ $totalCitas }}</h1>
        </div>

        <div class="card">
            <h3>Pendientes</h3>
            <h1>{{ $pendientes }}</h1>
        </div>

        <div class="card">
            <h3>Atendidas</h3>
            <h1>{{ $atendidas }}</h1>
        </div>

        <div class="card">
            <h3>Canceladas</h3>
            <h1>{{ $canceladas }}</h1>
        </div>
        <div class="card">
            <h3>
                @if($mes)
                    Ingresos del Mes
                @else
                    Ingresos del Año
                @endif
            </h3>
            <h1>${{ number_format($ingresosMes,0,',','.') }}</h1>
        </div>
    </div>

@endsection
