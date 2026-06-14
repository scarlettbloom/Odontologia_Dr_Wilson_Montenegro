<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

body{
    font-family: Arial, sans-serif;
    margin:30px;
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
.empresa{
    text-align:center;
    margin-bottom:25px;
}

.empresa h1{
    color:#005bb5;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    border:1px solid #000;
    padding:10px;
}

th{
    width:35%;
    background:#005bb5;
    color:white;
    text-align:left;
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
        Generada:
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
    <td>${{ number_format($venta->subtotal,0,',','.') }}</td>
</tr>

<tr>
    <th>Descuento</th>
    <td>${{ number_format($venta->descuento,0,',','.') }}</td>
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

</body>
</html>