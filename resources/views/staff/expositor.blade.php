<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <title>EXPO LMAD - SuperAdmin</title>
    @vite([
        "resources/css/staff/expositor.css",
        "resources/js/staff/qr-handler.js"
    ])
</head>

<body>
    <x-sidebar />

    <main class="main-content">

        <header>
            <h1 class="text-main">EXPOSITOR</h1>
            <span class="line"></span>
        </header>

        <section class="scanner-container">

            <div class="card card-left">
                <div id="reader-container" class="icon-placeholder">
                    <img src="{{ asset('assets/staff/QR-1.png') }}" alt="Barcode Icon" id="barcode-placeholder"
                        class="barcode-ico">
                    <div id="reader"></div>
                </div>

                <!--Esto es de prueba para mostrar el valor del QR escaneado, se puede eliminar después
                <div id="scanned-result" style="color: white; margin-top: 10px; margin-bottom: 20px; display: none;">
                    Matricula: <span id="qr-value"></span>
                    <br>
                    Estudiante: <span id="student-name"></span>
                    <br>
                    <button class="btn-primary" id="btn-registrar-asisencia" style="display:none"> Registrar
                        asistencia</button>
                </div>
                -->

                <button id="btn-permissions" class="btn-primary">Solicitar permisos de cámara</button>
            </div>

            <div class="card card-right">
                <div class="form-group">
                    <label for="camera-select">Cámara:</label>
                    <select id="camera-select" class="custom-select">
                        <option value="">Selecciona una cámara</option>
                    </select>
                </div>
                <button id="btn-start-scan" class="btn-primary ">Empezar a escanear</button>
            </div>

        </section>

        <div class="fondo-oscuro-modal" id="fondo-oscuro-modal">
            <div class="modal-content">
                <button class="close-modal" id="btn-close-modal">&times;</button>
                <h2>Registrar asistencia</h2>
                <p><b>Matricula:</b> <span id="modal-qr-value">1222222</span> </p>
                <p><b>Estudiante:</b> <span id="modal-student-name"> Juan Perez</span> </p>
                <button class="btn-primary" id="btn-registrar-asistencia">Registrar asistencia</button>
            </div>
        </div>


    </main>

</body>