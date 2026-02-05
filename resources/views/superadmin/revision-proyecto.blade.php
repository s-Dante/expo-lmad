<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>EXPO LMAD - SuperAdmin</title>
    @vite([
    "resources/css/superadmin/revision-proyecto.css"
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

                <h2 class="inner-title">Nombre del proyecto</h2>
                <p class="inner-subject">MATERIA</p>

                <div class="project-content">

                    <div class="info-side">

                        <div class="group-container header-info">

                            <div class="info-row">
                                <span class="label">ID DEL PROYECTO:</span>
                                <span class="value val-id">123</span>

                                <span class="label label-inline">SEMESTRE:</span>
                                <span class="value">SEXTO</span>
                            </div>

                            <div class="info-row">
                                <span class="label">MAESTRO:</span>
                                <span class="value">Diego Alan Adame</span>
                            </div>

                        </div>

                        <div class="group-container students-section">
                            <div class="info-row">
                                <span class="label">ALUMNOS:</span>

                                <div class="students-list">
                                    <div class="student-item">
                                        <span class="student-name">Juanito Alcachofa</span>
                                        <span class="student-id">123567</span>
                                    </div>
                                    <div class="student-item">
                                        <span class="student-name">Fulanito Perez</span>
                                        <span class="student-id">123568</span>
                                    </div>
                                    <div class="student-item">
                                        <span class="student-name">Merengano Manzana</span>
                                        <span class="student-id">123569</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="group-container links-section">
                            <div class="info-row">
                                <span class="label">VIDEO PROMOCIONAL:</span>
                                <div class="link-wrapper">
                                    <a href="#" class="url-text">https://www.youtube.com/watch?v=-4muHaXdZ6s&rco=1</a>
                                    <button class="btn-copy"><img src="{{ asset('assets/teacher/CopiarVector.png') }}"
                                            alt="Copiar"></img></button>
                                </div>
                            </div>

                            <div class="info-row">
                                <span class="label">ENLACE A PROYECTO:</span>
                                <div class="link-wrapper">
                                    <a href="#" class="url-text">https://github.com</a>
                                    <button class="btn-copy"><img src="{{ asset('assets/teacher/CopiarVector.png') }}"
                                            alt="Copiar"></img></button>
                                </div>
                            </div>
                        </div>

                        <div class="group-container description-section">
                            <div class="info-row">
                                <span class="label">DESCRIPCIÓN:</span>
                                <p class="description-text">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque
                                    ullamcorper porta feugiat. Pellentesque volutpat massa et neque
                                    facilisis pellentesque. Mauris id urna et libero luctus tincidunt
                                    tincidunt non ipsum. Nullam suscipit dapibus nunc quis suscipit.
                                    Aenean molestie laoreet volutpat.
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="image-side">
                        <div class="image-box">
                            <img src="{{ asset('assets/superadmin/img-default.png') }}" alt="Preview">
                        </div>
                    </div>

                </div>

                <div class="project-actions">

                    <div class="action-group" id="group-review">
                        <div class="row-top">
                            <button class="btn-pill btn-purple">
                                <div class="icon-container">
                                    <img src="{{ asset('assets/superadmin/lapiz-1.svg') }}" alt="" class="btn-icon">
                                </div>
                                Editar descripción
                            </button>

                            <button class="btn-pill btn-purple">Regresar</button>
                        </div>

                        <div class="row-bottom">
                            <button class="btn-pill btn-cyan">
                                <div class="icon-container">
                                    <img src="{{ asset('assets/superadmin/cheque-1.svg') }}" alt="" class="btn-icon">
                                </div> Aceptar proyecto
                            </button>
                            <button class="btn-pill btn-blue">
                                <div class="icon-container">
                                    <img src="{{ asset('assets/superadmin/flecha-izquierda-1.svg') }}" alt="" class="btn-icon">
                                </div> Devolver proyecto
                            </button>
                            <button class="btn-pill btn-magenta">
                                <div class="icon-container">
                                    <img src="{{ asset('assets/superadmin/cruz-1.svg') }}" alt="" class="btn-icon">
                                </div>Rechazar proyecto
                            </button>
                        </div>
                    </div>

                    <div class="action-group hidden" id="group-save">
                        <div class="row-top">
                            <button class="btn-pill btn-blue-dark">Guardar cambios</button>
                            <button class="btn-pill btn-purple">Regresar</button>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>
</body>