@props(['titulo', 'materia', 'estado'])

@php
    $btnClass = match ($estado) {
        'Aceptado' => 'btn-accepted',
        'Rechazado' => 'btn-rejected',
        'Correciones' => 'btn-warning',
        default => 'btn-ghost',
    };
@endphp

<div class="expo-card">
    <div class="div-project-data">
        <h2>{{ $titulo }}</h2>
        <center>
            <input type="text" disabled class="hr-gradient">
        </center>
        <h3>{{ $materia }}</h3>
    </div>
    <button class="btn {{ $btnClass }}">{{ $estado }} <span class="legend">Ver proyecto</span></button>
</div>
