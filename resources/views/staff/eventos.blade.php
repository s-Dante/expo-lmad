<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <title>EXPO LMAD - Staff</title>
    @vite([
    "resources/css/staff/eventos.css",
    "resources/js/staff/eventos-actions.js"
    ])
</head>

<body>
    <x-sidebar />
    <main class="main-content">

        <header>
            <h1 class="text-main">REGISTRO DE ENTRADA A EVENTO</h1>
            <span class="line"></span>
        </header>

        <form id="form-eventos" action="" method="POST" class="form-eventos">

            <section class="form-left">
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
                        <input class="input-c" type="text" id="matricula" name="matricula">
                    </div>


                    <label for="nombre">Nombre completo:</label>
                    <input class="input-c" type="text" id="nombre" name="nombre">

                </div>
            </section>

            <section class="form-right">
                <label class="label-eventos">Evento:</label>
                <div class="selector-container">
                    <input type="hidden" name="evento_seleccionado" id="evento_seleccionado" required>

                    <ul class="event-list" id="event-list">
                        <li class="event-item" data-value="doblaje">DOBLAJE PASIÓN Y VIDA</li>
                        <li class="event-item" data-value="dibujando">DIBUJANDO MIS SUEÑOS</li>
                        <li class="event-item" data-value="ux-experiencia">EXPERIENCIA DE USUARIO (UX) EN LA...</li>
                        <li class="event-item" data-value="xr-applied">EXTENDED REALITY APPLIED</li>
                        <li class="event-item" data-value="semilla-historia">DE UNA SEMILLA NACE UNA HISTORIA</li>
                        <li class="event-item" data-value="masterclass-unreal">MASTERCLASS: UNREAL ENGINE: NEW...</li>
                        <li class="event-item" data-value="indie-dev">INDIE GAME DEVELOPMENT ULTRA LMAD</li>
                    </ul>
                </div>
            </section>


            <div class="flex-break"></div>
            <button type="submit" class="btn-lg btn-purple">Registrar Visitante</button>
        </form>
    </main>
</body>