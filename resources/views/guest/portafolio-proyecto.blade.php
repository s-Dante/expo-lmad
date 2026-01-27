<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Debug Proyecto</title>
</head>

<body>

<h1>Debug - Proyecto</h1>

{{-- ============================================================
| 1. DATOS DIRECTOS DEL MODELO PROYECTO
============================================================ --}}
<p><strong>Título:</strong> {{ $proyecto->titulo }}</p>

<p><strong>Categoría (nombre):</strong> {{ $proyecto->getNombreCategoriaAttribute() ?? 'Sin Categoría' }}</p>
<p><strong>Categoría (objeto):</strong> {{ $proyecto->getCategoriaAttribute() ?? 'Sin Categoría' }}</p>

<p><strong>Descripción:</strong> {{ $proyecto->descripcion }}</p>

<hr>

{{-- ============================================================
| 2. RELACIÓN BELONGS TO: MATERIA
============================================================ --}}
<p><strong>Materia:</strong> {{ $proyecto->materia->nombre }}</p>

<hr>

{{-- ============================================================
| 3. RELACIÓN BELONGS TO: PROFESOR
============================================================ --}}
<p>
    <strong>Profesor:</strong>
    {{ $proyecto->profesor->nombre }}
    {{ $proyecto->profesor->apellido_paterno }}
</p>

<hr>

{{-- ============================================================
| 4. RELACIÓN MANY TO MANY: AUTORES
============================================================ --}}

@php
    $totalAutores = $proyecto->autores->count();
@endphp

<p>
    <strong>Tipo de participación:</strong>
    {{ $totalAutores > 1 ? 'Equipo' : 'Alumno' }}
</p>

<h3>Autores</h3>

@foreach($proyecto->autores as $autor)
    <p>
        {{ $autor->nombre }} {{ $autor->apellido_paterno }}
        @if($autor->pivot->es_lider)
            ← LÍDER (pivot)
        @endif
    </p>
@endforeach


<hr>

{{-- ============================================================
| 5. RELACIÓN ONE TO MANY: MULTIMEDIA
============================================================ --}}
<h3>Multimedia</h3>
<p>Total: {{ $proyecto->multimedia->count() }}</p>

@foreach($proyecto->multimedia as $media)
    <p>
        Tipo: {{ $media->tipo }} |
        URL: {{ $media->url }} |
        Portada: {{ $media->es_portada ? 'sí' : 'no' }}
    </p>
@endforeach

<hr>

{{-- ============================================================
| 6. RELACIÓN MANY TO MANY: SOFTWARES
============================================================ --}}
<h3>Softwares</h3>

@foreach($proyecto->softwares as $software)
    <p>
        {{ $software->software_name }}
        (Logo Path: {{ $software->logo_path ?? 'N/A' }})
    </p>
@endforeach

<hr>

{{-- ============================================================
| 7. DUMP COMPLETO
============================================================ --}}
<pre>
@json($proyecto, JSON_PRETTY_PRINT)
</pre>

</body>
</html>