<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EXPO LMAD - Estudiante</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/student/registro-proyecto.css',
        'resources/js/student/create-project.js',
        'resources/js/student/load-portrait.js'
    ])

</head>

<style>
    h2 {
        font-family: var(--font-main);
        color: var(--clr-white);
        font-size: 1.2rem;
        margin-top: 0%;
    }

    .btn-purple {
        font-size: 1.5rem;
    }

    .codigo {
        justify-content: center;
        width: -webkit-fill-available;
        margin-top: 1rem;
    }

    .codigo div p {
        font-family: var(--font-main);
        color: var(--clr-gray);
        margin: 0%;
    }

    .codigo div {
        display: flex;
        margin-bottom: 1rem;
        flex-direction: column;
        align-items: center;
    }

    .project-info {
        margin-bottom: 1rem;
    }

    .checkbox-card {
        width: fit-content;
        margin-bottom: unset;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 0.2rem;
    }

    .section-send {
        display: flex;
        gap: 1rem;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }
</style>

<body>
    <x-sidebar />

    <form class="main-content" action="{{ route('estudiante.proyectos.update', $proyecto->id) }}" method="POST"
        enctype="multipart/form-data" id="projectForm">
        @csrf
        @method('PUT')

        <h1>REGISTRO DE PROYECTO</h1>

        <div class="project-info">
            <div>
                <section class="expo-card project-data">

                    <span>Nombre del proyecto: </span>
                    <input type="text" id="name" name="titulo" value="{{ old('titulo', $proyecto->titulo) }}" required>

                    <span>Descripción del proyecto: </span>
                    <textarea type="text" class="input-description" id="description-project" name="descripcion"
                        required>{{ old('descripcion', $proyecto->descripcion) }}</textarea>

                    @php $youtube = $proyecto->multimedia->where('tipo', 'youtube')->first(); @endphp
                    <span>Enlace a video promocional: </span>
                    <input type="url" id="link-promotional-project" name="link_youtube"
                        placeholder="https://www.youtube.com/..." value="{{ old('link_youtube', $youtube?->url) }}"
                        required>

                    @php $drive = $proyecto->multimedia->where('tipo', 'drive')->first(); @endphp
                    <span>Enlace a Google Drive (Documentación): </span>
                    <input type="url" id="link-drive-project" name="link_drive" placeholder="Enlace a Drive (Opcional)"
                        value="{{ old('link_drive', $drive?->url) }}">

                    @php $github = $proyecto->multimedia->where('tipo', 'github')->first(); @endphp
                    <span>Enlace a proyecto: </span>
                    <input type="url" id="link-repo-project" name="link_github"
                        placeholder="drive, github, dropbox..." value="{{ old('link_github', $github?->url) }}">

                    <span>Software utilizado: </span>
                    <div class="container-proyecto-tags tags-list" id="software">
                        @foreach($softwares as $software)
                            <x-tag-checkbox name="softwares[]" id="{{ $software->id }}" value="{{ $software->id }}"
                                label="{{ $software->nombre }}" />
                        @endforeach
                    </div>

                </section>

                <section class="expo-card email-data">
                    <span>Correo universitario: </span>
                    <div class="div-email">
                        <div class="div-email">
                            <span>{{ auth()->user()->email }}</span>
                        </div>
                    </div>

                    <span class="info-secondary">
                        Este correo será utilizado como medio de comunicación con el estudiante para
                        notificarle si su proyecto fue aceptado, rechazado o si se necesitan hacer cambios para ser
                        admitido.
                        <br><br>
                        Favor de estar al pendiente una vez enviado el proyecto</span>
                </section>
            </div>

            <section class="expo-card picture-datas align-items-center">
                <span class="text-align-center">Foto del proyecto</span>
                <img id="project-portrait" src="{{ asset('assets/guest/imageloading.png') }}"
                    class="img-fluid project-card" />
                <input type="file" id="file-upload" name="poster" accept="image/*" style="display: none;">
                <x-btn-icon id="upload-photo" icon="{{ asset('assets/guest/upload.png') }}" />
                <span class="info-secondary">
                    El tamaño preciso para la foto es de 1024 x 1024 ppx
                </span>

                <section class="expo-card codigo">

                    <div>
                        <h2>Información del proyecto</h2>
                        <p>
                            ID:
                            <span>
                                {{ $proyecto->id }}
                            </span>
                        </p>
                        <p>
                            Maestro:
                            <span>
                                {{ $proyecto->profesor->apellido_paterno }}
                            </span>
                        </p>
                        <p>
                            Materia:
                            <span>
                                {{ $proyecto->materia->nombre }}
                            </span>
                        </p>
                    </div>

                    <span>Código de autorización: </span>
                    <input type="text" class="input-codigo" id="token" name="codigo_acceso"
                        placeholder="proporcionado por el docente" value="{{ old('codigo_acceso') }}" required>
                </section>
            </section>
        </div>

        <div class="section-send">
            <button id="save" type="submit" class="btn btn-purple">Guardar</button>

            <div class="tooltip">
                <section class="checkbox-card">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="enviar_revision" name="enviar_revision" value="1"
                            class="checkbox-input" {{ old('enviar_revision') ? 'checked' : '' }}>
                    </div>
                    <div for="enviar_revision" class="checkbox-label">
                        <span class="checkbox-title">Enviar a revisión al finalizar</span>
                    </div>
                </section>
                <span class="tooltiptext" style="width: 250px;">Si marcas esta casilla, el proyecto será enviado
                    inmediatamente luego de presionar "Guardar" para su
                    evaluación. De lo contrario, se guardará como <strong>borrador</strong>.</span>
            </div>
        </div>


    </form>

    <script type="module">
        import { showServerMessages } from "{{ Vite::asset('resources/js/components/flash-alerts.js') }}";

        showServerMessages(
            @json(session('success')),
            @json(session('error')),
            @json($errors->all())
        );
    </script>
</body>