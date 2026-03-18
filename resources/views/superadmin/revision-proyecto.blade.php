<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EXPO LMAD - SuperAdmin</title>
    @vite([
    "resources/css/superadmin/revision-proyecto.css",
    "resources/js/superadmin/actions-check.js",
    "resources/js/superadmin/revisar-proyecto.js"
    ])
</head>

<body>
    <x-sidebar />

    <main class="main-content">

        <header>
            <h1 class="text-main">Revisión de proyecto</h1>
            <span class="line"></span>
        </header>

        <section class="project-card">
            <div class="card-inner">

                <h2 class="inner-title">{{ $proyecto->titulo }}</h2>
                <p class="inner-subject">{{ $proyecto->materia->nombre }}</p>

                <input type="hidden" id="proyecto_id_input" name="proyecto_id" value="{{ $proyecto->id }}">
                <input type="hidden" id="descripcion_input" name="descripcion" value="{{ $proyecto->descripcion }}">

                <div class="project-content">

                    <div class="info-side">

                        <div class="group-container header-info">

                            <div class="info-row">
                                <span class="label">ID DEL PROYECTO:</span>
                                <span class="value val-id">{{ $proyecto->id }}</span>

                                <span class="label label-inline">SEMESTRE:</span>
                                <span class="value">{{ $proyecto->materia->semestre }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">MAESTRO:</span>
                                <span
                                    class="value">{{ $proyecto->profesor->nombre . ' ' . $proyecto->profesor->apellido_paterno . ' ' . $proyecto->profesor->apellido_materno }}</span>
                            </div>

                        </div>

                        <div class="group-container students-section">
                            <div class="info-row">
                                <span class="label">ALUMNOS:</span>

                                <div class="students-list">
                                    @foreach ($proyecto->autores as $autor)
                                    <div class="student-item">

                                        <span
                                            class="student-name">{{ $autor->nombre . ' ' . $autor->apellido_paterno . ' ' . $autor->apellido_materno   }}</span>
                                        <span class="student-id">{{ $autor->matricula }}</span>


                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="group-container links-section">
                            @foreach ($proyecto->multimedia as $multimedia)

                            {{-- Caso GITHUB --}}
                            @if ($multimedia->tipo === 'github')
                            <div class="info-row">
                                <span class="label">ENLACE A PROYECTO (GITHUB):</span>
                                <div class="link-wrapper">
                                    <a href="{{ $multimedia->url }}" class="url-text"
                                        target="_blank">{{ $multimedia->url }}</a>
                                    <button class="btn-copy">
                                        <img src="{{ asset('assets/teacher/CopiarVector.png') }}" alt="Copiar">
                                    </button>
                                </div>
                            </div>
                            @endif

                            {{-- Caso DRIVE --}}
                            @if ($multimedia->tipo === 'drive')
                            <div class="info-row">
                                <span class="label">ENLACE A PROYECTO (DRIVE):</span>
                                <div class="link-wrapper">
                                    <a href="{{ $multimedia->url }}" class="url-text"
                                        target="_blank">{{ $multimedia->url }}</a>
                                    <button class="btn-copy">
                                        <img src="{{ asset('assets/teacher/CopiarVector.png') }}" alt="Copiar">
                                    </button>
                                </div>
                            </div>
                            @endif

                            {{-- Caso YOUTUBE --}}
                            @if ($multimedia->tipo === 'youtube')
                            <div class="info-row">
                                <span class="label">VIDEO PROMOCIONAL (YOUTUBE):</span>
                                <div class="link-wrapper">
                                    <a href="{{ $multimedia->url }}" class="url-text"
                                        target="_blank">{{ $multimedia->url }}</a>
                                    <button class="btn-copy">
                                        <img src="{{ asset('assets/teacher/CopiarVector.png') }}" alt="Copiar">
                                    </button>
                                </div>
                            </div>
                            @endif

                            @endforeach
                        </div>

                        <div class="group-container description-section">
                            <div class="info-row">
                                <span class="label">DESCRIPCIÓN:</span>
                                <p id="text-desc" class="description-text">
                                    {{ $proyecto->descripcion }}
                                </p>

                                <textarea id="edit-desc" class="description-editor hidden"></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="image-side">
                        <div class="image-box">
                            @foreach ($proyecto->multimedia as $multimedia)
                            @if ($multimedia->tipo == 'imagen')
                            <img src="{{ asset('storage/' . $multimedia->url) }}" alt="Imagen del proyecto"
                                class="project-image">
                            @endif
                            @endforeach
                        </div>
                    </div>

                </div>


                <div class="project-actions">

                    <div class="action-group" id="group-review">
                        <div class="row-top">
                            <div class="btn-group-container">


                                <div class="tooltip-container">
                                    <button class="btn-help" ><i class="fas fa-question"></i></button>

                                    <span class="tooltip-text">
                                        Editar la descripción no
                                        notificará al expositor.
                                    </span>
                                </div>

                                <!-- Editar Descripción btn -->
                                <button id="btn-edit-desc" class="btn-pill btn-purple">
                                    <div class="icon-container">
                                        <img src="{{ asset('assets/superadmin/lapiz-1.svg') }}" alt="" class="btn-icon">
                                    </div>
                                    Editar descripción
                                </button>
                            </div>

                            <button class="btn-pill btn-purple" onclick="window.location.href='/superadmin/proyectos'">
                                Regresar
                            </button>
                        </div>

                        <div class="row-bottom">

                            <!-- Aceptar proyecto-->
                            <button id="btn-accept-project" class="btn-pill btn-cyan">
                                <div class="icon-container">
                                    <img src="{{ asset('assets/superadmin/cheque-1.svg') }}" alt="" class="btn-icon">
                                </div> Aceptar proyecto
                            </button>
                            <div class="btn-group-container">
                                <div class="tooltip-container">
                                     <button class="btn-help" ><i class="fas fa-question"></i></button>

                                    <span class="tooltip-text">
                                        Devolver el proyecto permite al
                                        expositor corregir o mejorar
                                        información sobre su exposición.
                                        Se le notifica automáticamente
                                        al expositor por correo.
                                    </span>

                                </div>

                                <!-- Devolver proyecto-->
                                <button id="btn-open-return" class="btn-pill btn-blue-medium">
                                    <div class="icon-container">
                                        <img src="{{ asset('assets/superadmin/flecha-izquierda-1.svg') }}" alt=""
                                            class="btn-icon">
                                    </div> Rechazar proyecto
                                </button>
                            </div>

                            <!-- Rechazar proyecto-->
                            <button id="btn-reject-project" class="btn-pill btn-magenta">
                                <div class="icon-container">
                                    <img src="{{ asset('assets/superadmin/cruz-1.svg') }}" alt="" class="btn-icon">
                                </div>Eliminar proyecto
                            </button>

                        </div>
                    </div>

                    <div class="action-group hidden center" id="group-save">
                        <div class="row-top">
                            <!-- Botones de aceptar-cancelar descripción-->
                            <button id="btn-save-desc" class="btn-pill btn-blue-dark">Guardar cambios</button>
                            <button id="btn-cancel-edit" class="btn-pill btn-purple">Regresar</button>
                        </div>
                    </div>
                </div>

                <div id="return-panel" class="hidden">
                    <span class="line second"></span>

                    <div class="return-content">
                        <p class="return-label">
                            Mensaje con las correcciones solicitadas al alumno para su aceptación en el CONGRESO LMAD:
                        </p>

                        <textarea id="return-msg" class="description-editor"
                            placeholder="Escribe aquí las observaciones..."></textarea>
                    </div>

                    <div class="project-actions ">
                        <div class="row-top center">
                            <!-- Botones de aceptar-cancelar Devolver proyecto-->
                            <button id="btn-confirm-return" class="btn-pill btn-blue-dark">Devolver proyecto</button>
                            <button id="btn-cancel-return" class="btn-pill btn-purple">Regresar</button>
                        </div>
                    </div>
                </div>


            </div>
        </section>

    </main>
</body>