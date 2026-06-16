<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

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

<div class="logo">
    <img src="{{ public_path('img/WILSON.png') }}" width="120" height="120">
</div>

<div class="empresa">
    <h1>Odontología Dr. Wilson Montenegro</h1>

    <p>Factura de Venta</p>

    <p>
        Fecha de generación:
        {{ now()->format('d/m/Y H:i') }}
    </p>
</div>

<table>

<tr>
    <th>Factura N°</th>
    <td>FAC-{{ $venta->idventa }}</td>
</tr>

<tr>
    <th>Producto</th>
    <td>{{ $venta->producto->nombre ?? 'No disponible' }}</td>
</tr>

<tr>
    <th>Cantidad</th>
    <td>{{ $venta->cantidad }}</td>
</tr>

<tr>
    <th>Subtotal</th>
    <td>
        <strong>
            ${{ number_format($venta->subtotal,0,',','.') }}
        </strong>
    </td>
</tr>

<tr>
    <th>Descuento</th>
    <td>
    <strong>
        ${{ number_format($venta->descuento,0,',','.') }}
    </strong>
    </td>
</tr>

<tr>
    <th>Total</th>
    <td>
        <strong>
            ${{ number_format($venta->total,0,',','.') }}
        </strong>
    </td>
</tr>

<tr>
    <th>Fecha de compra</th>
    <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
</tr>

</table>

<div class="observacion">
    <strong>Observaciones:</strong><br>
    Este documento certifica la venta del producto odontológico registrado en el sistema.
</div>

<div class="footer">
    Odontología Dr. Wilson Montenegro |
    Página 1
</div>

</body>
</html>