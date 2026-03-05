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
                    <img src="{{ asset('assets/staff/QR-1.png') }}" alt="Barcode Icon" id="barcode-placeholder" class="barcode-ico">
                    <div id="reader"></div>
                </div>
                
                <!--Esto es de prueba para mostrar el valor del QR escaneado, se puede eliminar después-->
                <div id="scanned-result" style="color: white; margin-top: 10px; margin-bottom: 20px;">
                    Valor: <span id="qr-value"></span>
                </div>

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

    </main>

</body>