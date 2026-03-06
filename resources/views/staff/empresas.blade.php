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

        <div id="tabla-revision" class="table-wrapper">
            <table class="proyectos-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>Wacom</td>
                        <td>
                            <button class="btn-accion" onclick="window.location.href='/staff/empresas/asistencia'">
                                Asistencia
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Wacom2</td>
                        <td>
                            <button class="btn-accion">
                                Asistencia
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Wacom3</td>
                        <td>
                            <button class="btn-accion">
                                Asistencia
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>


    </main>

</body>