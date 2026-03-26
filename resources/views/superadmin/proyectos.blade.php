<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SuperAdmin Proyectos</title>
    @vite([
        "resources/css/superadmin/proyectos.css",
        "resources/css/components/superadmin/modal-ver.css",
        "resources/js/superadmin/proyectos-handler.js",
        "resources/js/superadmin/proyectos-info.js"

    ])
</head>

<body>
    <x-sidebar />

    <main class="main-content">

        <header>
            <h1 class="text-main">Proyectos</h1>
            <span class="line"></span>
        </header>

        <section class="projects-header">
            <div class="stats-grid-projects">

                <div class="stat-mini-card">
                    <span class="stat-value" id="expositores-span">0</span>
                    <span class="stat-label">EXPOSITORES</span>
                </div>

                <div class="stat-mini-card">
                    <span class="stat-value" id="proyectos-span">0</span>
                    <span class="stat-label">PROYECTOS RECIBIDOS</span>
                </div>

                <div class="stat-mini-card">
                    <span class="stat-value" id="aceptados-span">0</span>
                    <span class="stat-label">PROYECTOS ACEPTADOS</span>
                </div>

                <div class="stat-mini-card">
                    <span class="stat-value" id="rechazados-span">0</span>
                    <span class="stat-label">PROYECTOS RECHAZADOS</span>
                </div>

            </div>


        </section>

        <div class="filter-tabs">
            <button class="tab-btn cian active" id="btn-revisión">Proyectos en revisión</button>
            <button class="tab-btn morado" id="btn-aceptado">Proyectos aceptados</button>
        </div>

        <section class="projects-content">

            <h3 class="subtitle">Proyectos en revisión</h3>

            <div class="filter-row">
                <div class="select-group">
                    <label>MATERIA:</label>
                    <select>
                        <option selected disabled>Seleccione una opción</option>
                        @foreach ($materias as $materia)
                            <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="select-group">
                    <label>DOCENTE:</label>
                    <select>
                        <option selected disabled>Seleccione una opción</option>
                        @foreach ($profesores as $profesor)
                            <option value="{{ $profesor->id }}">
                                {{ $profesor->nombre . ' ' . $profesor->apellido_paterno . ' ' . $profesor->apellido_materno}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <h4 class="info-title">Información</h4>

            <div id="tabla-revision" class="table-wrapper">
                <table class="proyectos-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Materia</th>
                            <th>Docente</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($proyectosRevision as $revisadendo)
                            <tr>
                                <td>{{ $revisadendo->id }}</td>
                                <td>{{ $revisadendo->materia->nombre }}</td>
                                <td>{{ $revisadendo->profesor->nombre . ' ' . $revisadendo->profesor->apellido_paterno . ' ' . $revisadendo->profesor->apellido_materno }}
                                </td>
                                <td>
                                    <button class="btn-revisar"
                                        onclick="window.location.href='/superadmin/revision-proyecto/{{ $revisadendo->id }}'">
                                        Revisar proyecto
                                        <img src="{{ asset('assets/superadmin/revisar 1.png') }}" alt="Revisar"
                                            class="btn-icon" />
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="tabla-aceptados" class="table-wrapper hidden">
                <table class="proyectos-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Materia</th>
                            <th>Docente</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody class="pagination-container">
                        @foreach ($proyectosAprobados as $aprobadendos)
                            <tr class="paginated-item">
                                <td>{{ $aprobadendos->id }}</td>
                                <td>{{ $aprobadendos->materia->nombre }} </td>
                                <td>{{ $aprobadendos->profesor->nombre . ' ' . $aprobadendos->profesor->apellido_paterno . ' ' . $aprobadendos->profesor->apellido_materno}}
                                </td>
                                <td>
                                    <button class="btn-ver" 
                                    onclick="prepararModal({{ $aprobadendos->id }})">
                                        Ver proyecto
                                    </button>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>

            <div class="pagination">

                <button class="page-arrow prev">
                    <img class="arrow-icon" src="{{ asset('assets/superadmin/Polygon-1.png') }}">
                </button>

                <div class="page-number">1</div>

                <button class="page-arrow next">
                    <img class="arrow-icon" src="{{ asset('assets/superadmin/Polygon-2.png') }}">
                </button>
            </div>

        </section>

    </main>

    <x-superadmin.modal-ver />
</body>