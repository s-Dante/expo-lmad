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

<style>
    h1 {
        color: var(--clr-blue-100);
        font-family: var(--font-display);
        font-weight: 10;
        text-align: center;
    }

    span {
        font-family: var(--font-main);
        color: var(--clr-white);
    }

    input {
        background: var(--input-flat);
        border: 0;
        border-bottom: 3px solid var(--contrast-color-D);
        border-radius: 10px;
        color: var(--text-primary);
        font-family: var(--font-main);
        padding: 8px 15px;
        outline: none;
        text-align: center;
        position: relative;
        width: -webkit-fill-available;
    }

    .main-content {
        top: 4rem;
        position: absolute;
        padding: 1rem;
        width: -webkit-fill-available;
    }

    .expo-card {
        display: grid;
        justify-content: center;
        margin-bottom: 1rem;
        width: auto;
        height: fit-content;
        padding: 2rem 1.5rem;
        position: relative;
        border-radius: 18px;
        gap: 0.4rem;
    }

    .info-secondary{
        text-align: center;
        color: var(--clr-gray);
    }

    .project-card{
        width: 12rem;
        height: 12rem;
        border-radius: 1rem;
    }

</style>

<body>
    <x-sidebar />

    <div class="main-content">
        <h1>REGISTRO DE PROYECTO</h1>

        <section class="expo-card project-data">

            <span>Nombre del proyecto: </span>
            <input type="text" class="">

            <span>Descripción del proyecto: </span>
            <input type="text" class="">

            <span>Enlace a video promocional: </span>
            <input type="text" class="">

            <span>Enlace a proyecto: </span>
            <input type="text" class="" placeholder="drive, github, dropbox...">

            <span>Código de autorización: </span>
            <input type="text" class="">

        </section>

        <section class="expo-card ematil-data">
            <span>Correo: </span>
            <input type="text" class="">

            <span class="info-secondary">Este correo será utilizado como medio de comunicación con el estudiante para notificarle si su
                proyecto fue aceptado, rechazado o si se necesitan hacer cambios para ser admitido.
                <br><br>
                Favor de estar al pendiente una vez enviado el proyecto</span>
        </section>

        <section class="expo-card picture-datas">
            <img src="{{ asset('assets/guest/imageloading.png') }}" class="img-fluid project-card"/>
            <button class="btn btn-purple">a</button>
        </section>

        <button type="submit" class="btn-save">Guardar</button>

    </div>



</body>