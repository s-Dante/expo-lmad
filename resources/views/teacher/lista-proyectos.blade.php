<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>EXPO LMAD - Maestros</title>
    @vite([
    'resources/css/teacher/lista-proyectos.css',
    'resources/css/components/teacher/modal-editar.css',
    'resources/js/teacher/modalEditar.js'
    ])
</head>

<body>
    <x-sidebar />

    <main class="main-content">
        <h1 class="text-main">LISTA DE PROYECTOS</h1>
        <section class="projects-grid">

            <article class="card-project">
                <h2 class="project-title">ADADAT</h2>
                <p class="project-subtitle">Administración de Alto Volumen de Datos</p>

                <div class="token-container">
                    <span>Token: 52563-64bad69f5d44c4--7-17292</span>
                    <button class="btn-copy"><img src="{{ asset('assets/teacher/CopiarVector.png') }}" alt="Copiar"></img></button>
                </div>

                <div class="project-members">
                    <div class="member-item">
                        <p>Matrícula: 1994104</p>
                        <p>Alumno: alumno123</p>
                    </div>

                    <div class="member-item">
                        <p>Matrícula: 1994104</p>
                        <p>Alumno: alumno123</p>
                    </div>
                </div>

                <div class="status-check">
                    <input type="checkbox" id="check-datos" checked>
                    <label for="check-datos">Datos entregados</label>
                </div>

                <div class="card-actions">

                    <button class="btn-action edit" onclick="abrirModal()">
                        <img src="{{ asset('assets/teacher/EditarIcon.png') }}" alt="Editar">
                    </button>
                    <button class="btn-action help"><i class="fas fa-question"></i></button>
                </div>
            </article>

            <article class="card-project">
                <h2 class="project-title">ADADAT</h2>
                <p class="project-subtitle">Administración de Alto Volumen de Datos</p>

                <div class="token-container">
                    <span>Token: 52563-64bad69f5d44c4--7-17292</span>
                    <button class="btn-copy"><img src="{{ asset('assets/teacher/CopiarVector.png') }}" alt="Copiar"></img></button>
                </div>

                <div class="project-members">
                    <div class="member-item">
                        <p>Matrícula: 1994104</p>
                        <p>Alumno: alumno123</p>
                    </div>

                    <div class="member-item">
                        <p>Matrícula: 1994104</p>
                        <p>Alumno: alumno123</p>
                    </div>
                </div>

                <div class="status-check">
                    <input type="checkbox" id="check-datos" checked>
                    <label for="check-datos">Datos entregados</label>
                </div>

                <div class="card-actions">

                    <button class="btn-action edit" onclick="abrirModal()">
                        <img src="{{ asset('assets/teacher/EditarIcon.png') }}" alt="Editar">
                    </button>
                    <button class="btn-action help"><i class="fas fa-question"></i></button>
                </div>
            </article>
        </section>

    </main>

    <x-teacher.modal-editar />
</body>