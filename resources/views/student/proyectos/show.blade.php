<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EXPO LMAD - Estudiante</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/student/revisar-exposicion.css',
        'resources/js/student/copy-link.js'
    ])

</head>

<body>
    <x-sidebar />

    <main>
        <h1>Respuesta al proyecto enviado</h1>

        <container class="container-warning">
            <span>
                Tras enviar tu proyecto al CONGRESO LMAD, se realizará una revisión para verificar que se cumpla con
                los estándares esperados del evento. En este apartado podrás ver la respuesta tras que sea revisado, a
                su vez, se enviará un aviso a tu correo universitario si necesita hacerle cambios para su aceptación.
                <br><br>
                Favor de estar al pendiente una vez enviado el proyecto. No olvides revisar tu correo spam!
            </span>
        </container>

        <section class="section-project-data">
            <form action="" class="expo-card main-card">

                <section>
                    <div class="section-project-header">
                        <h2 id="name">{{ $proyecto->titulo ?? 'Sin título definido' }}</h2>
                        <h3 id="subject">{{ $proyecto->materia->nombre }}</h3>
                    </div>

                    <div class="two-columns-grid general-grid">
                        <div class="three-rows-grid">

                            <div class="two-columns-grid">

                                <div class="two-columns-grid two-category-grid">
                                    <span>Id del proyecto:</span>
                                    <p id="id">{{ $proyecto->id }}</p>
                                    <span>Maestro:</span>
                                    <p id="teacher">{{ $proyecto->profesor->nombre }}
                                        {{ $proyecto->profesor->apellido_paterno }}
                                    </p>
                                </div>

                                <div class="two-columns-grid two-category-grid">
                                    <span>Semestre:</span>
                                    <p id="semester">{{ $proyecto->materia->semestre }}</p>
                                </div>

                            </div>

                            <div class="two-columns-grid two-category-grid">
                                <span>Alumnos:</span>

                                <div class="two-columns-grid">
                                    @foreach($proyecto->autores as $autor)
                                        <p>{{ $autor->nombre }} {{ $autor->apellido_paterno }}
                                            @if($autor->pivot->es_lider)
                                                (Líder)
                                            @endif
                                        </p>
                                        <p>{{ $autor->matricula }}</p>
                                    @endforeach
                                </div>
                            </div>

                            <div class="three-rows-grid">

                                <div class="three-columns-grid three-category-grid">
                                    <span>Video promocional:</span>

                                    @php $video = $proyecto->multimedia->where('tipo', 'youtube')->first(); @endphp
                                    @if($video)
                                        <p id="link-promotional-project" class="state-saved">
                                            {{ $video->url }}
                                        </p>
                                    @endif

                                    <input type="text" class="input-c state-editing" id="link-promotional-edit" />
                                    <button class="btn btn-purple btn-icon state-saved" id="link-promotional-copy"
                                        data-target="link-promotional-project"><img
                                            src="{{ asset('assets/guest/upload.png') }}"></button>
                                </div>

                                <div class="three-columns-grid three-category-grid">
                                    <span>Enlace a proyecto:</span>

                                    @php
                                        $repo = $proyecto->multimedia->whereIn('tipo', ['drive', 'github'])->first();
                                    @endphp

                                    @if($repo)
                                        <p id="link-repo-project" class="state-saved">{{ $repo->url }}</p>
                                    @endif
                                    <input type="text" class="input-c state-editing" id="link-repo-edit" />
                                    <button class="btn btn-purple btn-icon state-saved" id="link-repo-copy"
                                        data-target="link-repo-project"><img
                                            src="{{ asset('assets/guest/upload.png') }}"></button>
                                </div>

                                <div class="two-columns-grid two-category-grid">
                                    <span>Descripción:</span>
                                    <p id="description-project" class="state-saved">
                                        {{ $proyecto->descripcion ?? 'Sin descripción disponible.' }}
                                    </p>
                                    <textarea class="input-description state-editing" id="description-edit"
                                        value="{{ $proyecto->descripcion ?? 'Sin descripción disponible.' }}"></textarea>
                                </div>

                            </div>

                        </div>

                        <div class="img-project">
                            <img src="{{ asset('assets/guest/imageloading.png') }}" class="img-fluid">

                            <div class="div-btn-changeimage">
                                <button type="button" class="btn btn-blue state-editing">Cambiar imagen</button>
                            </div>
                        </div>

                    </div>
                </section>

                <center>
                    <input type="text" disabled class="hr-gradient">
                </center>

                <section class="project-retro">
                    <h4>Estado del proyecto</h4>

                    @if($proyecto->estatus === 'rechazado' && $proyecto->retroalimentacion)
                        <p id="state">
                            Se han encontrado aspectos en los que puedes mejorar. Tan pronto como termines de optimizar tu
                            proyecto enviálo de nuevo.
                        </p>
                        <div class="expo-card project-retro-msg" id="message">
                            <span>Mensaje del congreso:</span>
                            <p id="msg">{{ $proyecto->retroalimentacion }}</p>
                        </div>
                    @elseif ($proyecto->estatus === 'borrador' || $proyecto->estatus === 'enviado')
                        <p id="state">
                            En revisión, ¡No olvides estar al pendiente!
                        </p>
                    @elseif ($proyecto->estatus === 'aprobado')
                        <p id="state">
                            Aceptado
                        </p>
                    @elseif ($proyecto->estatus === 'rechazado' || $proyecto->estatus === 'eliminado')
                        <p id="state">
                            Rechazao
                        </p>
                    @endif


                    @php
                        $miParticipacion = $proyecto->autores->find(auth()->user()->estudiante->id);
                        $soyLider = $miParticipacion ? $miParticipacion->pivot->es_lider : false;
                    @endphp

                    @if($proyecto->estatus === 'rechazado' && $proyecto->retroalimentacion && $soyLider)
                        <div class="div-btns-project">

                            <button type="button" class="btn btn-blue state-saved" id="edit">Editar proyecto</button>
                            <button type="submit" class="btn btn-darkpur state-saved" id="resend">Reenviar proyecto</button>

                            <button type="button" class="btn btn-blue state-editing" id="save">Guardar cambios</button>
                            <button type="button" class="btn btn-purple state-editing" id="back">Regresar</button>

                        </div>
                    @endif

                </section>

            </form>

        </section>

    </main>

    @vite('resources/js/student/show-hide-elements.js')
</body>