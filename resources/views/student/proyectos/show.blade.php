<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EXPO LMAD - Estudiante</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/student/revisar-exposicion.css',
        'resources/css/components/alerts.css',
        'resources/js/student/copy-link.js',
        'resources/js/student/update-project.js',
        'resources/js/components/load-portrait.js'
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
            <form action="{{ route('estudiante.proyectos.updateEdit', $proyecto->id) }}" method="POST"
                enctype="multipart/form-data" id="projectForm" class="expo-card main-card">
                @csrf
                @method('PUT')

                <section>
                    <div class="section-project-header">
                        <h2 id="name">
                            {{ $proyecto->titulo ?? 'Sin título definido' }}
                        </h2>
                        <input type="hidden" name="titulo" value="{{ old('titulo', $proyecto->titulo) }}">
                        <h3 id=" subject">{{ $proyecto->materia->nombre }}</h3>
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

                                    <p id="link-promotional-project" class="state-saved">
                                        @if($video)
                                            {{ $video->url }}
                                        @else
                                            No disponible.
                                        @endif
                                    </p>

                                    <input type="text" name="link_youtube" class="input-c state-editing"
                                        id="link-promotional-edit" value="{{ $video?->url }}" style="display: none;" />

                                    <x-btn-copy id="link-promotional-copy" target="link-promotional-project" />
                                </div>

                                <div class="three-columns-grid three-category-grid">
                                    <span>Documentación:</span>

                                    @php $drive = $proyecto->multimedia->where('tipo', 'drive')->first(); @endphp

                                    <p id="link-drive-project" class="state-saved">
                                        @if($drive)
                                            {{ $drive->url }}
                                        @else
                                            No disponible.
                                        @endif
                                    </p>

                                    <input type="text" name="link_drive" class="input-c state-editing"
                                        id="link-drive-edit" value="{{ $drive?->url }}" style="display: none;" />

                                    <x-btn-copy id="link-drive-copy" target="link-drive-project" />
                                </div>

                                <div class="three-columns-grid three-category-grid">
                                    <span>Enlace a proyecto:</span>

                                    @php
                                        $repo = $proyecto->multimedia->whereIn('tipo', ['drive', 'github'])->first();
                                    @endphp

                                    <p id="link-repo-project" class="state-saved">
                                        @if($repo)
                                            {{ $repo->url }}
                                        @else
                                            No disponible
                                        @endif
                                    </p>

                                    <input type="text" name="link_github" class="input-c state-editing"
                                        id="link-repo-edit" value="{{ $repo?->url }}" style="display: none;" />

                                        <x-btn-copy id="link-repo-copy" target="link-repo-project" />
                                </div>

                                <div class="two-columns-grid two-category-grid">
                                    <span>Descripción:</span>
                                    <p id="description-project" class="state-saved">
                                        {{ $proyecto->descripcion ?? 'Sin descripción disponible.' }}
                                    </p>
                                    <textarea name="descripcion" class="input-description state-editing"
                                        id="description-edit" style="display: none;">{{ $proyecto->descripcion ?? 'Sin descripción disponible.' }}</textarea>
                                </div>

                            </div>

                        </div>

                        <div class="img-project">

                            @php
                                $portada = $proyecto->multimedia->where('es_portada', true)->first();
                                $defaultImg = 'https://via.placeholder.com/300x300?text=Subir+Imagen';
                                $currentImg = $portada ? \App\Services\ImagenService::url($portada->url) : $defaultImg;
                            @endphp

                            <img src="{{ $currentImg }}" class="img-fluid project-card" id="project-portrait">

                            <div class="div-btn-changeimage">
                                <button type="button" id="upload-photo" class="btn btn-blue state-editing" style="display: none;" data-target="file-upload" onclick="triggerUpload(this)">Cambiar
                                    imagen</button>
                                <input type="file" id="file-upload" name="poster" accept="image/*"
                                    style="display: none;" data-preview="project-portrait">
                                <input type="hidden" id="has-image" value="{{ $portada ? 'true' : 'false' }}">
                            </div>


                            <div class="project-softwares">
                                <span>Software utilizado: </span>
                                <div class="state-saved">
                                    <div class="tags-list">
                                        @foreach($proyecto->softwares as $software)
                                            <div class="tooltip">
                                                <p>
                                                    {{ $software->nombre }}
                                                </p>
                                                <span class="tooltiptext">{{ $software->descripcion }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="state-editing" style="display: none;">
                                    <div class="container-proyecto-tags tags-list" id="software">
                                        @php
                                            $selectedSoftwares = $proyecto->softwares->pluck('id')->toArray();
                                        @endphp
                                        @foreach($softwares as $software)
                                            <x-tag-checkbox name="softwares[]" id="{{ $software->id }}"
                                                value="{{ $software->id }}" label="{{ $software->nombre }}"
                                                :checked="in_array($software->id, $selectedSoftwares)" />
                                        @endforeach
                                    </div>
                                </div>

                                <span class="d-none" id="token">
                                    {{ $proyecto->codigo_acceso }}
                                </span>
                                <input type="hidden" name="codigo_acceso" value="{{ $proyecto->codigo_acceso }}">
                            </div>

                        </div>

                    </div>
                </section>

                <center>
                    <input type="text" disabled class="hr-gradient">
                </center>

                <section class="project-retro">
                    <h4>Estado del proyecto</h4>

                    <p id="state">
                        @if($proyecto->estatus === 'rechazado')
                            <p id="state">
                                Se han encontrado aspectos en los que puedes mejorar. <br> Tan pronto como termines de optimizar
                                tu
                                proyecto enviálo de nuevo.
                            </p>
                            <div class="expo-card project-retro-msg" id="message">
                                <span>Mensaje del congreso:</span>
                                @if($proyecto->retroalimentacion)
                                    <p id="msg">{{ $proyecto->retroalimentacion }}</p>
                                @else
                                    <p id="msg">Póngase en contacto con expo.lmad@uanl.edu.mx</p>
                                @endif
                            </div>
                        @elseif ($proyecto->estatus === 'borrador')
                        Sin enviar. ¡Recuerda enviar el proyecto a revisión!
                    @elseif ($proyecto->estatus === 'enviado')
                        En revisión, ¡No olvides estar al pendiente!
                    @elseif ($proyecto->estatus === 'aprobado')
                        Aceptado
                    @elseif ($proyecto->estatus === 'eliminado')
                        Rechazao
                    @endif
                    </p>

                    @php
                        $miParticipacion = $proyecto->autores->find(auth()->user()->estudiante->id);
                        $soyLider = $miParticipacion ? $miParticipacion->pivot->es_lider : false;
                    @endphp

                    @if(($proyecto->estatus === 'rechazado' || $proyecto->estatus === 'borrador') && $soyLider)
                        <div class="div-btns-project">

                            <div class="state-saved">
                                <div class="d-flex" style="gap: 1rem; justify-content: center;">
                                    <button type="button" class="btn btn-blue" id="edit">Editar proyecto</button>
                                    <button type="button" class="btn btn-darkpur" id="resend">Reenviar proyecto</button>
                                </div>
                            </div>

                            <div class="state-editing" style="display: none;">
                                <div class="d-flex" style="gap: 1rem; justify-content: center;">
                                    <button type="button" class="btn btn-blue" id="save">Guardar cambios</button>
                                    <button type="button" class="btn btn-purple" id="back">Regresar</button>
                                </div>
                            </div>

                        </div>
                    @endif

                </section>

            </form>

        </section>

    </main>

    {{-- Datos de sesión y rutas para el JS (sin inline module imports) --}}
    <div id="page-data"
         data-flash-success=@json(session('success'))
         data-flash-error=@json(session('error'))
         data-flash-errors=@json($errors->all())
         data-resend-url="{{ route('estudiante.proyectos.send', $proyecto->id) }}"
         style="display:none"></div>

    @vite('resources/js/student/actions-revisar-exposicion.js')

</body>