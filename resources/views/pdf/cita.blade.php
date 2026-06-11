<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Cita</title>

    <style>
        body{
            font-family: Arial, sans-serif;
        }

        h1{
            text-align:center;
        }

        table{
            width:100%;
            border-collapse: collapse;
            margin-top:20px;
        }

        th,td{
            border:1px solid #000;
            padding:10px;
        }

        th{
            background:#005bb5;
            color:white;
        }
    </style>
</head>
<body>

<h1>Reporte de Cita Odontológica</h1>

<table>
    <tr>
        <th>ID Cita</th>
        <td>{{ $cita->IDcita }}</td>
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
    <td>
        ${{ number_format($cita->Precio ?? 0, 0, ',', '.') }}
    </td>
</tr>
</table>

</body>
</html>