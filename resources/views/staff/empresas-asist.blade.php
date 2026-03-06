<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <title>EXPO LMAD - Staff</title>
    @vite([
    "resources/css/staff/empresas.css"
    ])
</head>

<body>
    <x-sidebar />
    <main class="main-content">
        <header>
            <h1 class="text-main">EMPRESAS</h1>
            <span class="line"></span>
        </header>
    </main>

</body>