<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

                    @forelse($empresas as $empresa)
                    <tr>
                        <td>{{ $empresa->nombre }}</td>
                        <td>
                            <a href="{{ route('staff.empresa-asistencia', $empresa->id) }}"
                               class="btn-accion">
                                Asistencia
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" style="text-align:center; padding: 2rem; opacity: 0.6;">
                            No hay empresas registradas aún.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </main>

</body>
</html>
