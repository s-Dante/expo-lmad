@props(['data'])

@php
    $btnClass = match ($data->estatus) {
        'aprobado' => 'btn-accepted',
        'eliminado' => 'btn-rejected',
        'rechazado' => 'btn-warning',
        'borrador' => 'btn-draft',
        default => 'btn-ghost',
    };

    $msj = match ($data->estatus) {
        'aprobado' => 'Aprobado',
        'eliminado' => 'Rechazado',
        'rechazado' => 'Correcciones',
        'borrador' => 'Borrador',
        default => 'En revisión',
    };

    $esIndividual = $data->autores->count() <= 1;
    $tituloSeccion = $esIndividual ? 'Proyecto Individual' : 'Equipo de Trabajo';
@endphp

<div class="expo-card">
    <div class="div-project-data">

        <div class="div-project-header">

            <div class="tooltip">
                <button class="btn {{ $btnClass }}">{{ $msj }}</button>

                @if ($data->estatus === 'aprobado')
                    <span class="tooltiptext">¡Felicidades! Tu proyecto ha sido aprobado para la Expo.</span>
                @elseif ($data->estatus === 'eliminado')
                    <span class="tooltiptext">Lo sentimos</span>
                @elseif($data->estatus === 'rechazado')
                    <span class="tooltiptext">Se han encontrado correcciones para mejorar el portafolio.</span>
                @elseif($data->estatus === 'borrador')
                    <span class="tooltiptext">Tu proyecto está en modo edición. Solo tú y tu equipo pueden verlo.</span>
                @else
                    <span class="tooltiptext">El proyecto está siendo revisado por el profesor. No puedes editarlo por
                        ahora.</span>
                @endif
            </div>

            <div>
                <p>Materia:</p>
                <h3>{{ $data->materia->nombre }}</h3>
            </div>

        </div>

        <center>
            <input type="text" disabled class="hr-gradient">
        </center>

        <h2>{{ $data->titulo ?? 'Sin asignar' }}</h2>

        <p>{{ $data->descripcion ?? 'Sin asignar' }}</p>


        <div class="div-project-teacher">
            <p>Asigando por: <span>Prof. {{ $data->profesor->nombre }} {{ $data->profesor->apellido_paterno }}</span>
            </p>
        </div>

        <div class="div-project-team">
            <h4>{{ $tituloSeccion }}</h4>

            @if(!$esIndividual)
                @foreach ($data->autores as $autor)
                    <p>{{ $autor->nombre }} {{ $autor->apellido_paterno }}</p>
                @endforeach
            @endif

        </div>

    </div>

    @if($data->estatus === 'aprobado')

        <div class="div-accepted-btns">
            <a href="{{ route('proyecto.show', $data->slug) }}" class="btn {{ $btnClass }}">
                <p class="legend">Ver portafolio</p>
            </a>

            <a href="{{ route('estudiante.proyectos.show', $data->id) }}" class="btn btn-draft">
                <p class="legend">Ver proyecto</p>
            </a>
        </div>

    @else

        @if($data->estatus === 'borrador')
            <a href="{{ route('estudiante.proyectos.create', $data->id) }}" class="btn {{ $btnClass }}">
                <p class="legend">Editar proyecto</p>
            </a>
        @else
            <a href="{{ route('estudiante.proyectos.show', $data->id) }}" class="btn {{ $btnClass }}">
                @if($data->estatus === 'rechazado')
                    <p class="legend">Revisar proyecto</p>
                @elseif($data->estatus === 'eliminado')
                    <p class="legend">No disponible</p>
                @else
                    <p class="legend">Ver proyecto</p>
                @endif
            </a>
        @endif

    @endif

</div>