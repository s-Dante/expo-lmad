<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EXPO LMAD - Estudiante</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/student/registro-proyecto.css'
    ])

</head>

<body>
    <x-sidebar />

    <form class="main-content">
        <h1>REGISTRO DE PROYECTO</h1>

        <div class="project-info">
            <section class="expo-card project-data">

                <span>Nombre del proyecto: </span>
                <input type="text" class="">

                <span>Descripción del proyecto: </span>
                <textarea type="text" class="input-description"></textarea>

                <span>Enlace a video promocional: </span>
                <input type="text" class="">

                <span>Enlace a proyecto: </span>
                <input type="text" class="" placeholder="drive, github, dropbox...">

                <span>Código de autorización: </span>
                <input type="text" class="" placeholder="proporcionado por el docente">

            </section>

            <section class="expo-card picture-datas align-items-center">
                <span class="text-align-center">Foto del proyecto</span>
                <img src="{{ asset('assets/guest/imageloading.png') }}" class="img-fluid project-card" />
                <button class="btn btn-purple btn-icon"><img class="img-fluid img-icon"
                        src="{{ asset('assets/guest/upload.png') }}"></button>
                <span class="info-secondary">
                    El tamaño máximo para la foto es de *inserte medidas*
                </span>
            </section>
        </div>

        <section class="expo-card email-data">
            <span>Correo universitario: </span>
            <div class="div-email">
                <input type="text" class="input-mail">
                <span>@uanl.edu.mx</span>
            </div>

            <span class="info-secondary">Este correo será utilizado como medio de comunicación con el estudiante para
                notificarle si su
                proyecto fue aceptado, rechazado o si se necesitan hacer cambios para ser admitido.
                <br><br>
                Favor de estar al pendiente una vez enviado el proyecto</span>
        </section>

        <button type="submit" class="btn btn-purple">Enviar</button>

    </form>



</body>