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
            @foreach ($proyectosProfesor as $proyecto)
                <article class="card-project" data-proyecto-id="{{ $proyecto->id }}">
                    <h2 class="project-title">{{$proyecto->titulo}}</h2>
                    <p class="project-subtitle">{{ $proyecto->materia->nombre }}</p>

                    <div class="token-container">
                        <span>Token: {{ $proyecto->codigo_acceso }}</span>
                        <button class="btn-copy"><img src="{{ asset('assets/teacher/CopiarVector.png') }}"
                                alt="Copiar"></img></button>
                    </div>

                    <div class="project-members">
                        <div class="member-item">
                            <p>Matrícula: {{ $proyecto->autores[0]->matricula }}</p>
                            <p>Lider:
                                {{ $proyecto->autores[0]->nombre . ' ' . $proyecto->autores[0]->apellido_paterno . ' ' . $proyecto->autores[0]->apellido_materno}}
                            </p>
                        </div>


                    </div>

                    @if ($proyecto->estatus === 'aprobado')
                        <div class="status-check">
                            <input type="checkbox" checked disabled>
                            <label for="check-datos">Datos entregados</label>
                        </div>
                    @else
                        <div class="status-check">
                            <input type="checkbox" disabled>
                            <label for="check-datos">Datos entregados</label>
                        </div>
                    @endif

                    <div class="card-actions">

                        <button class="btn-action edit" onclick="abrirModal()">
                            <img src="{{ asset('assets/teacher/EditarIcon.png') }}" alt="Editar">
                        </button>
                        <button class="btn-action help"><i class="fas fa-question"></i></button>
                    </div>
                </article>


            @endforeach


        </section>

    </main>

    <x-teacher.modal-editar />
</body>