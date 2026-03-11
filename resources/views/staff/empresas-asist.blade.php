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

        <section class="section-container">
            <form action="" method="POST" class="form-horizontal">
                <div class="input-inline">
                    <label for="nombre_asistencia">Nombre completo:</label>
                    <input type="text" id="nombre_asistencia">
                </div>

                <div class="actions">
                    <div class="checkbox-group">
                        <input type="checkbox" id="asistio" name="asistio">
                        <label for="asistio" class="custom-checkbox"></label>
                        <span>Asistió</span>
                    </div>
                    <div class="tooltip-container">
                        <button class="btn-help"><i class="fas fa-question"></i></button>
                        <span class="tooltip-text">
                            Favor de agregar a todos
                            los asistentes antes de enviar
                            el formulario de asistencia.
                        </span>

                    </div>
                    <button type="submit" class="btn-accion">Enviar</button>
                </div>


            </form>
        </section>

        <section class="second-section">
            <form action="" method="POST" class="form-vertical">
                <div class="input-wrapper">
                    <label for="nombre_empresa">Nombre completo:</label>
                    <input type="text" id="nombre_empresa">
                </div>

                <button type="submit" class="btn-accion">Añadir</button>
            </form>
        </section>
    </main>

</body>