<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>Factura de Cita Odontológica</title>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 30px;
        color: #333;
    }

    .encabezado {
        width: 100%;
        margin-bottom: 25px;
    }

    .logo {
        width: 120px;
        height: 120px;
        border: 2px dashed #999;
        text-align: center;
        line-height: 120px;
        color: #777;
        font-size: 12px;
        margin-bottom: 15px;
    }

    .empresa {
        text-align: center;
    }

    .empresa h1 {
        color:rgb(0, 0, 0);
        margin-bottom: 5px;
        font-size: 28px;
    }

    .empresa p {
        margin: 3px 0;
        font-size: 14px;
    }

    .info-factura {
        margin-top: 25px;
        margin-bottom: 20px;
    }

    .info-factura p {
        margin: 5px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 10px;
    }

    th {
        background:rgb(255, 255, 255);
        color: black;
        text-align: left;
        width: 35%;
    }

    .precio {
        font-weight: bold;
        color:rgb(0, 0, 0);
    }

    .footer {
        position: fixed;
        bottom: 10px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 16px;
        color: #666;
    }

    .observacion {
        margin-top: 30px;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background: #f8f9fa;
    }
</style>

</head>

<body>

<!-- ESPACIO PARA LOGO -->
<div class="logo">
    <img src="{{ public_path('img/WILSON.png') }}" width="120" height="120">
</div>

<div class="empresa">
    <h1>Odontología Dr. Wilson Montenegro</h1>

    <p>Factura de Atención Odontológica</p>

    <p>
        Fecha de generación:
        {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </p>
</div>

<div class="info-factura">
    <p><strong>Factura N°:</strong> FAC-{{ $cita->IDcita }}</p>
    <p><strong>ID de Cita:</strong> {{ $cita->IDcita }}</p>
</div>

<table>
    <tr>
        <th>Paciente</th>
        <td>{{ $cita->NombrePaciente }}</td>
    </tr>

    <tr>
        <th>Correo</th>
        <td>{{ $cita->Email }}</td>
    </tr>

    <tr>
        <th>Servicio</th>
        <td>{{ $cita->Servicio ?? 'No asignado' }}</td>
    </tr>

    <tr>
        <th>Precio</th>
        <td class="precio">
            ${{ number_format($cita->Precio ?? 0, 0, ',', '.') }}
        </td>
    </tr>

    <tr>
        <th>Fecha Entrada</th>
        <td>{{ \Carbon\Carbon::parse($cita->Fecha_entrada)->format('d/m/Y H:i') }}</td>
    </tr>

    <tr>
        <th>Fecha Salida</th>
        <td>{{ \Carbon\Carbon::parse($cita->Fecha_salida)->format('d/m/Y H:i') }}</td>
    </tr>

    <tr>
        <th>Estado</th>
        <td>{{ $cita->Estado }}</td>
    </tr>
</table>

<div class="observacion">
    <strong>Observaciones:</strong><br>
    Este documento certifica la programación y/o atención de la cita odontológica registrada en el sistema.
</div>

<div class="footer">
    Odontología Dr. Wilson Montenegro |
    Página 1
</div>

</body>
</html>
