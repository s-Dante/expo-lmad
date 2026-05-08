@props(['evento'])

@php
    $name = $evento->titulo;
    $type = $evento->tipo instanceof \App\Enums\TipoEvento ? $evento->tipo->value : (string) $evento->tipo;
    $dateStart = $evento->fecha_inicio_evento->format('d-m-Y');
    $timeStart = $evento->fecha_inicio_evento->format('H:i');
    $dateEnd = $evento->fecha_fin_evento->format('d-m-Y');
    $timeEnd = $evento->fecha_fin_evento->format('H:i');
    $location = $evento->ubicacion_evento ?? '';
    $capacity = $evento->capacidad ?? '';
    $editUrl = route('admin.eventos.update', $evento);
    $deleteUrl = route('admin.eventos.destroy', $evento);
    $confIds = $evento->conferencistas->pluck('id')->join(',');
@endphp

<div class="expo-card card-c">

    @if ($evento->poster_evento)
        <div class="card-event-poster" style="overflow: hidden; max-height: 140px; border-radius: 8px 8px 0 0;">
            <img src="{{ asset('storage/' . $evento->poster_evento) }}" alt="{{ $name }}"
                 style="width: 100%; height: 140px; object-fit: cover; display: block;">
        </div>
    @endif

    <div class="card-data">

        <div class="card-info-name">

            <h3>{{ $name }}</h3>
            <div class="card-visitor">
                <p> {{ ucfirst($type) }} </p>

                <p> Hora inicio: <span>{{ $timeStart }} hrs</span> </p>
                <p> Hora salida: <span>{{ $timeEnd }} hrs</span> </p>

                <p> {{ $dateStart }} </p>

            </div>

        </div>

        <div class="card-actions">

            <button id="btn-edit" class="btn btn-purple btn-icon" type="button"
                onclick="openEditModal('{{ $evento->id }}', '{{ addslashes($name) }}', '{{ addslashes($type) }}', '{{ $evento->fecha_inicio_evento->format('Y-m-d\TH:i') }}', '{{ $evento->fecha_fin_evento->format('Y-m-d\TH:i') }}', '{{ addslashes($location) }}', '{{ $capacity }}', '{{ $confIds }}', '{{ $editUrl }}')">
                <img class="img-fluid img-icon" src="{{ asset('assets/admin/EditarIcon.png') }}">
            </button>
            <form action="{{ $deleteUrl }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este evento?')">
                @csrf
                @method('DELETE')
                <x-btn-icon id="btn-delete" icon="{{ asset('assets/admin/BorrarIcon.png') }}" />
            </form>
        </div>

    </div>

</div>