@props(['titulo', 'materia', 'estado', 'descripcion'])

@php
    $btnClass = match ($estado) {
        'aprobado' => 'btn-accepted',
        'eliminado' => 'btn-rejected',
        'rechazado' => 'btn-warning',
        'borrador' => 'btn-draft',
        default => 'btn-ghost',
    };

    $msj = match ($estado) {
        'aprobado' => 'Aprobado',
        'eliminado' => 'Rechazado',
        'rechazado' => 'Correcciones',
        'borrador' => 'Borrador',
        default => 'En revisión',
    };
@endphp

<div class="expo-card">
    <div class="div-project-data">
        <h2>{{ $titulo }}</h2>
        <center>
            <input type="text" disabled class="hr-gradient">
        </center>
        <h3>{{ $materia }}</h3>

        <p>{{ $descripcion }}</p>
    </div>
    <button class="btn {{ $btnClass }}">{{ $msj }} <span class="legend">Ver proyecto</span></button>
</div>