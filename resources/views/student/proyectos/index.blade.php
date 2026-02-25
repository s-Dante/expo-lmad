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

            @forelse($proyectos as $proyecto)

                <x-student.project-card titulo="{{ $proyecto->titulo ?? 'Sin asignar.' }}" materia="{{ $proyecto->materia->nombre }}"
                    estado="{{ $proyecto->estatus }}" descripcion="{{ $proyecto->descripcion ?? 'Sin asignar.' }}" />

            @empty
            @endforelse


        </section>

    </main>

</body>