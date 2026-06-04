<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Servicio</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI',sans-serif;
        }

        body{
            background: linear-gradient(135deg,#e3f2fd,#bbdefb);
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
        }

        .container{
            width:100%;
            max-width:700px;
            background:white;
            padding:35px;
            border-radius:20px;
            box-shadow:0 10px 30px rgba(0,0,0,0.15);
        }

        .logo{
            text-align:center;
            font-size:60px;
            margin-bottom:10px;
        }

        h1{
            text-align:center;
            color:#1565c0;
            margin-bottom:25px;
        }

        .form-group{
            margin-bottom:20px;
        }

        label{
            display:block;
            margin-bottom:8px;
            font-weight:bold;
        }

        input,
        textarea{
            width:100%;
            padding:12px;
            border:1px solid #ccc;
            border-radius:10px;
        }

        textarea{
            resize:none;
            height:120px;
        }

        .btn{
            width:100%;
            background:#1976d2;
            color:white;
            border:none;
            padding:14px;
            border-radius:10px;
            cursor:pointer;
            font-size:16px;
        }

        .btn:hover{
            background:#0d47a1;
        }

        .volver{
            display:block;
            text-align:center;
            margin-top:15px;
            text-decoration:none;
            color:#1565c0;
            font-weight:bold;
        }

    </style>

</head>
<body>

<div class="container">

    <div class="logo">🦷</div>

    <h1>Editar Servicio</h1>

    <form action="{{ route('admin.servicios.update', $servicio->idservicio) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre del Servicio</label>

            <input
                type="text"
                name="nombre"
                value="{{ $servicio->nombre }}"
                required>
        </div>

        <div class="form-group">
            <label>Descripción</label>

            <textarea
                name="descripcion"
                required>{{ $servicio->descripcion }}</textarea>
        </div>

        <div class="form-group">
            <label>Costo (COP)</label>

            <input
                type="number"
                name="costo"
                value="{{ $servicio->costo }}"
                required>
        </div>

        <button type="submit" class="btn">
            💾 Actualizar Servicio
        </button>

    </form>

    <a href="{{ route('admin.servicios.index') }}" class="volver">
        ⬅ Volver al listado
    </a>

</div>

</body>
</html>
