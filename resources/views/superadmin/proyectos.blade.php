<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SuperAdmin Proyectos</title>
    @vite([
    "resources/css/superadmin/proyectos.css"
    ])
</head>

<body>
    <div class="sidebar">
        <x-sidebar />
    </div>
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
            <button class="tab-btn cian active">Proyectos en revisión</button>
            <button class="tab-btn morado">Proyectos aceptados</button>
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

            <div class="table-container">
                <table class="proyectos-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Materia</th>
                            <th>Docente</th>
                            <th>Revisar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>123</td>
                            <td>Producción multimedia</td>
                            <td>Diego Alan Adame</td>
                            <td><button class="btn-revisar"><i class="icon-eye"></i> Revisar proyecto</button></td>
                        </tr>
                        <tr>
                            <td>26</td>
                            <td>Modelos de administración de datos</td>
                            <td>Juan Alejandro Villareal Mojica</td>
                            <td><button class="btn-revisar">Revisar proyecto</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <button class="prev">◀</button>
                <span class="page-num">1</span>
                <button class="next">▶</button>
            </div>

        </section>

    </main>
</body>