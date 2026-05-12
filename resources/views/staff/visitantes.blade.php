<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <title>EXPO LMAD - Staff</title>
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

        @if (session('success'))
        <div style="background: rgba(46,204,113,0.15); color: #2ecc71; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; text-align: center;">
            {{ session('success') }}
        </div>
        @endif
        @if ($errors->any())
        <div style="background: rgba(231, 76, 60, 0.15); color: #e74c3c; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; text-align: center;">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form id="form-visitante" action="{{ route('staff.visitantes.store') }}" method="POST" class="form-visitor">
            @csrf
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

                <label for="correo">Correo:</label>
                <input class="input-c" type="text" id="correo" name="correo">

                <div class="select-group">
                    <label for="genero">Género:</label>
                    <select class="input-c" id="genero" name="genero">
                        <option value="">Seleccionar</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                        <option value="O">Otro</option>
                    </select>

                    <label for="edad">Edad:</label>
                    <select class="input-c" id="edad" name="edad">
                        <option value="">Seleccionar</option>
                        <option value="<15">-15</option>
                        <option value="15-25">15-25</option>
                        <option value="26-35">26-35</option>
                        <option value="36-45">36-45</option>
                        <option value="46-55">46-55</option>
                        <option value="56+">56+</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-lg btn-purple">Registrar Visitante</button>

            <div class="tooltip-container">
                <button class="btn-help"><i class="fas fa-question"></i></button>
                <span class="tooltip-text">
                    No se necesita registrar la salida.
                    Este registro no valida el AFI.
                </span>

            </div>
        </form>

    </main>
</body>