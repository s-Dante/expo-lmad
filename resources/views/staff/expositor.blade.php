<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EXPO LMAD - SuperAdmin</title>
    @vite([
    "resources/css/staff/expositor.css"
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
                <div class="icon-placeholder">
                    <img src="{{ asset('assets/staff/QR-1.png') }}" alt="Barcode Icon" class="barcode-ico">
                </div>
                <button class="btn-primary">Solicitar permisos de cámara</button>
            </div>

            <div class="card card-right">
                <div class="form-group">
                    <label for="camera-select">Cámara:</label>
                    <select id="camera-select" class="custom-select">
                        <option value="">Selecciona una cámara</option>
                    </select>
                </div>
                <button class="btn-primary btn-large">Empezar a escanear</button>
            </div>

        </section>

    </main>

</body>