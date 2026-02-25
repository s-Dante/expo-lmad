<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EXPO LMAD - Estudiante</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/student/lista-exposiones.css'
    ])

</head>

<body>
    <x-sidebar />

    <main>
        <h1>Exposiciones</h1>

        <section class="section-expositions">

            <x-student.project-card
                titulo="Proyecto rimbombástico"
                materia="Programación orientada a objetos"
                estado="En revisión"
            />

            <x-student.project-card
                titulo="Proyecto rimbombástico"
                materia="Programación orientada a objetos"
                estado="Correciones"
            />

            <x-student.project-card
                titulo="Proyecto rimbombástico"
                materia="Programación orientada a objetos"
                estado="Aceptado"
            />

            <x-student.project-card
                titulo="Proyecto rimbombástico"
                materia="Programación orientada a objetos"
                estado="Rechazado"
            />

        </section>

    </main>

</body>