<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SuperAdmin Proyectos</title>
    @vite([
    "resources/css/superadmin/proyectos.css",
    "resources/js/superadmin/proyectos-handler.js"
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
                    <span class="stat-value">201</span>
                    <span class="stat-label">EXPOSITORES</span>
                </div>

                <div class="stat-mini-card">
                    <span class="stat-value">53</span>
                    <span class="stat-label">PROYECTOS ACEPTADOS</span>
                </div>

                <div class="stat-mini-card">
                    <span class="stat-value">80</span>
                    <span class="stat-label">PROYECTOS RECIBIDOS</span>
                </div>

                <div class="stat-mini-card">
                    <span class="stat-value">12</span>
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
                        <option>Seleccione una opción</option>
                    </select>
                </div>
                <div class="select-group">
                    <label>DOCENTE:</label>
                    <select>
                        <option>Seleccione una opción</option>
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
                        <tr>
                            <td>123</td>
                            <td>Producción multimedia</td>
                            <td>Diego Alan Adame</td>
                            <td>
                                <button class="btn-revisar">
                                    <img src="{{ asset('assets/superadmin/revisar 1.png') }}" alt="Revisar" class="btn-icon">
                                    Revisar proyecto
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>26</td>
                            <td>Modelos de administración de datos</td>
                            <td>Juan Alejandro Villareal Mojica</td>
                            <td>
                                <button class="btn-revisar">
                                    <img src="{{ asset('assets/superadmin/revisar 1.png') }}" alt="Revisar" class="btn-icon">
                                    Revisar proyecto
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>78</td>
                            <td>Modelado orgánico</td>
                            <td>Alberta Abigail Palacios Garza</td>
                            <td>
                                <button class="btn-revisar">
                                    <img src="{{ asset('assets/superadmin/revisar 1.png') }}" alt="Revisar" class="btn-icon">
                                    Revisar proyecto
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>123</td>
                            <td>Producción multimedia</td>
                            <td>Diego Alan Adame</td>
                            <td>
                                <button class="btn-revisar">
                                    <img src="{{ asset('assets/superadmin/revisar 1.png') }}" alt="Revisar" class="btn-icon">
                                    Revisar proyecto
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>26</td>
                            <td>Modelos de administración de datos</td>
                            <td>Juan Alejandro Villareal Mojica</td>
                            <td>
                                <button class="btn-revisar">
                                    <img src="{{ asset('assets/superadmin/revisar 1.png') }}" alt="Revisar" class="btn-icon">
                                    Revisar proyecto
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>78</td>
                            <td>Modelado orgánico</td>
                            <td>Alberta Abigail Palacios Garza</td>
                            <td>
                                <button class="btn-revisar">
                                    <img src="{{ asset('assets/superadmin/revisar 1.png') }}" alt="Revisar" class="btn-icon">
                                    Revisar proyecto
                                </button>
                            </td>
                        </tr>
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
                    <tbody>
                        <tr>
                            <td>123</td>
                            <td>Producción multimedia</td>
                            <td>Mamá coco</td>
                            <td>
                                <button class="btn-ver"> Ver proyecto </button>
                            </td>
                        </tr>
                        <tr>
                            <td>26</td>
                            <td>Modelos de administración de datos</td>
                            <td>Juan Alejandro Villareal Mojica</td>
                            <td>
                                <button class="btn-ver"> Ver proyecto </button>
                            </td>
                        </tr>
                        <tr>
                            <td>78</td>
                            <td>Modelado orgánico</td>
                            <td>Alberta Abigail Palacios Garza</td>
                            <td>
                                <button class="btn-ver"> Ver proyecto </button>
                            </td>
                        </tr>
                        <tr>
                            <td>123</td>
                            <td>Producción multimedia</td>
                            <td>Diego Alan Adame</td>
                            <td>
                                <button class="btn-ver"> Ver proyecto </button>
                            </td>
                        </tr>
                        <tr>
                            <td>26</td>
                            <td>Modelos de administración de datos</td>
                            <td>Juan Alejandro Villareal Mojica</td>
                            <td>
                                <button class="btn-ver"> Ver proyecto </button>
                            </td>
                        </tr>
                        <tr>
                            <td>78</td>
                            <td>Modelado orgánico</td>
                            <td>Alberta Abigail Palacios Garza</td>
                            <td>
                                <button class="btn-ver"> Ver proyecto </button>
                            </td>
                        </tr>
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
</body>