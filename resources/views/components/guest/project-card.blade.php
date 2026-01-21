@props(['materia' => 'Materia', 'nombreProyecto' => 'Nombre del Proyecto'])

<div class="project-card-slot">
    <div {{ $attributes->merge(['class' => 'project-card-container']) }}>
        <div class="project-card-border">
            <div class="project-card-info">
                <p class="project-card-titulo BrunoAce-font">{{ $materia }}</p>
                <p class="project-card-subtitulo">{{ $nombreProyecto }}</p>
            </div>
        </div>
    </div>
</div>
