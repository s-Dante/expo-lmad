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
        <h1>Proyectos a exponer</h1>

        <section class="section-expositions">

            @forelse($proyectos as $proyecto)

                <x-student.project-card :data="$proyecto" />

            @empty
            @endforelse


        </section>

    </main>

</body>