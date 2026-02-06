@props(['materia' => 'Materia', 'nombreProyecto' => 'Nombre del Proyecto'])

<div class="project-card-slot">
    <div class="project-card-container">
        <div class="project-card-border" {{ $attributes }}>
            <div class="project-card-info">
                <p class="project-card-titulo BrunoAce-font">{{ $materia }}</p>
                <p class="project-card-subtitulo">{{ $nombreProyecto }}</p>
            </div>
        </div>
    </div>
</div>
