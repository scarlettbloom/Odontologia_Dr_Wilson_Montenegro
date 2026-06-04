<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Servicio</title>

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
            color:#333;
        }

        input,
        textarea,
        select{
            width:100%;
            padding:12px;
            border:1px solid #ccc;
            border-radius:10px;
            font-size:15px;
        }

        input:focus,
        textarea:focus,
        select:focus{
            outline:none;
            border-color:#2196f3;
        }

        textarea{
            resize:none;
            height:120px;
        }

        small{
            display:block;
            margin-top:8px;
            color:#666;
            font-size:13px;
        }

        .btn{
            width:100%;
            background:#1976d2;
            color:white;
            border:none;
            padding:14px;
            border-radius:10px;
            font-size:16px;
            cursor:pointer;
            transition:0.3s;
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

        .volver:hover{
            text-decoration:underline;
        }

        .info-box{
            background:#f5f9ff;
            border-left:5px solid #2196f3;
            padding:15px;
            border-radius:10px;
            margin-bottom:20px;
        }

        .info-box h3{
            color:#1565c0;
            margin-bottom:10px;
        }

        .info-box p{
            margin-bottom:5px;
            color:#444;
        }

        #costo{
            background:#f1f8ff;
            font-weight:bold;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="logo">🦷</div>

    <h1>Registrar Servicio Odontológico</h1>

    <div class="info-box">
        <h3>Servicios Disponibles</h3>

        <p>🦷 Limpieza Dental</p>
        <p>✨ Blanqueamiento Dental</p>
        <p>😁 Ortodoncia</p>
        <p>🔧 Extracción Dental</p>
        <p>🩺 Endodoncia</p>
        <p>🦷 Implante Dental</p>
        <p>😊 Diseño de Sonrisa</p>
        <p>📋 Control Odontológico</p>
        <p>📷 Radiografía Dental</p>
    </div>

    <form action="{{ route('admin.servicios.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Tipo de Servicio</label>

            <select
                name="nombre"
                id="servicio"
                required
                onchange="actualizarCosto()">

                <option value="">Seleccione un servicio</option>

                <option value="Limpieza Dental" data-costo="80000">
                    🦷 Limpieza Dental
                </option>

                <option value="Blanqueamiento Dental" data-costo="250000">
                    ✨ Blanqueamiento Dental
                </option>

                <option value="Ortodoncia" data-costo="1500000">
                    😁 Ortodoncia
                </option>

                <option value="Extracción Dental" data-costo="120000">
                    🔧 Extracción Dental
                </option>

                <option value="Endodoncia" data-costo="350000">
                    🩺 Endodoncia
                </option>

                <option value="Implante Dental" data-costo="2000000">
                    🦷 Implante Dental
                </option>

                <option value="Diseño de Sonrisa" data-costo="1000000">
                    😊 Diseño de Sonrisa
                </option>

                <option value="Control Odontológico" data-costo="60000">
                    📋 Control Odontológico
                </option>

                <option value="Radiografía Dental" data-costo="50000">
                    📷 Radiografía Dental
                </option>

            </select>

            <small>
                Seleccione el procedimiento odontológico.
            </small>
        </div>

        <div class="form-group">
            <label>Descripción</label>

            <textarea
                name="descripcion"
                placeholder="Descripción del procedimiento odontológico"></textarea>
        </div>

        <div class="form-group">
            <label>Costo del Servicio (COP)</label>

            <input
                type="number"
                id="costo"
                name="costo"
                readonly
                required>

            <small>
                El valor se asigna automáticamente según el servicio seleccionado.
            </small>
        </div>

        <button type="submit" class="btn">
            💾 Guardar Servicio
        </button>

    </form>

    <a href="{{ route('admin.servicios.index') }}" class="volver">
        📋 Ver Servicios Registrados
    </a>

</div>

<script>
function actualizarCosto() {

    const servicio = document.getElementById('servicio');
    const costo = document.getElementById('costo');

    const opcionSeleccionada =
        servicio.options[servicio.selectedIndex];

    costo.value =
        opcionSeleccionada.getAttribute('data-costo') || '';
}
</script>

</body>
</html>

