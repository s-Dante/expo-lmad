<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <title>EXPO LMAD - SuperAdmin</title>
    @vite([
    "resources/css/staff/visitantes.css",
    "resources/js/staff/visitantes-actions.js"
    ])
</head>

<body>
    <x-sidebar />
    <main class="main-content">

        <header>
            <h1 class="text-main">VISITANTES</h1>
            <span class="line"></span>
        </header>

        <form action="" method="POST" class="form-visitor">
            <div class="type-vistor">

                <div class="group-radio">
                    <input type="radio" id="alumno" name="tipo_visitante" value="alumno">
                    <label for="alumno">Alumno</label>
                </div>
                <div class="group-radio">
                    <input type="radio" id="externo" name="tipo_visitante" value="visitante">
                    <label for="externo">Externo</label>
                </div>


            </div>

            <div class="form-group">
                <div id="container-matricula">
                    <label for="matricula">Matrícula:</label>
                    <input type="text" id="matricula" name="matricula" required>
                </div>

                <label for="nombre">Nombre completo:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="genero">Género:</label>
                <select id="genero" name="genero" required>
                    <option value="">Seleccionar</option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                    <option value="otro">Otro</option>
                </select>
            </div>

            <button type="submit" class="btn-primary">Registrar Visitante</button>
        </form>

    </main>
</body>