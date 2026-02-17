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
    .btn-purple {
        font-size: 1.5rem;
    }

    .codigo {
        justify-content: center;
        width: -webkit-fill-available;
        margin-top: 1rem;
    }

    .project-info {
        margin-bottom: 1rem;
    }

</style>

<body>
    <x-sidebar />

    <form class="main-content">
        <h1>REGISTRO DE PROYECTO</h1>

        <div class="project-info">
            <div>
                <section class="expo-card project-data">

                    <span>Nombre del proyecto: </span>
                    <input type="text" id="name">

                    <span>Descripción del proyecto: </span>
                    <textarea type="text" class="input-description" id="description-project"></textarea>

                    <span>Enlace a video promocional: </span>
                    <input type="text" id="link-promotional-project">

                    <span>Enlace a proyecto: </span>
                    <input type="text" id="link-repo-project" placeholder="drive, github, dropbox...">

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
                        <input type="text" class="input-mail" id="email">
                        <span>@uanl.edu.mx</span>
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
                    <span>Código de autorización: </span>
                    <input type="text" class="input-codigo" id="token" placeholder="proporcionado por el docente">
                </section>
            </section>
        </div>

        <button id="save" type="submit" class="btn btn-purple">Enviar</button>

    </form>

</body>