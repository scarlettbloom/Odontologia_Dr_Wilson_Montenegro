<!DOCTYPE html>
<html>
<head>
    <title>Clínica Dr. Wilson Montenegro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f6f9;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .card-menu{
            width:700px;
            border:none;
            border-radius:15px;
        }

        .btn-menu{
            height:120px;
            font-size:24px;
            font-weight:bold;
        }
    </style>
</head>

<body>

<div class="card shadow card-menu">

    <div class="card-body text-center p-5">

        <h1 class="mb-4">
            Clínica Dr. Wilson Montenegro
        </h1>

        <p class="text-muted mb-5">
            Seleccione el módulo al que desea ingresar
        </p>

        <div class="row">

            <div class="col-md-6 mb-3">

                <a href="{{ route('inventario.index') }}"
                   class="btn btn-primary w-100 btn-menu">

                    📦 Inventario

                </a>

            </div>

            <div class="col-md-6 mb-3">

                <a href="{{ route('cliente.productos') }}"
                   class="btn btn-success w-100 btn-menu">

                    👤 Cliente

                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>