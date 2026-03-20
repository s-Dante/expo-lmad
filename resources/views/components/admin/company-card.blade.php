@props(['patrocinador'])

@php
    $name = $patrocinador->nombre;
    $tier = $patrocinador->tier;
    $image = $patrocinador->logo_url
        ? (str_starts_with($patrocinador->logo_url, 'http') ? $patrocinador->logo_url : asset('storage/' . $patrocinador->logo_url))
        : null;
    $website = $patrocinador->website_url ?? '';
    $editUrl = route('admin.patrocinadores.update', $patrocinador);
    $deleteUrl = route('admin.patrocinadores.destroy', $patrocinador);
@endphp

<div class="expo-card card-c">

    <div class="card-data">
        @if ($image)
            <div class="card-company-logo">
                <img src="{{ $image }}" alt="{{ $name }}">
            </div>
        @endif

        @if ($tier)
            <div class="card-company-info-sponsor">
                <x-guest.sponsor-tier :tier="$tier" />
        @else
                <div class="card-info-name">
            @endif
                <h3>{{ $name }}</h3>
                <div class="card-visitor">
                    <p>Web:</p>
                    <span>{{ $website ?: 'Sin sitio web' }}</span>
                </div>
            </div>
        </div>

        <div class="card-actions">

            <button id="btn-edit" class="btn btn-purple btn-icon" type="button"
                onclick="openEditModal('{{ $patrocinador->id }}', '{{ addslashes($name) }}', '{{ addslashes($tier ?? '') }}', '{{ addslashes($image ?? '') }}', '{{ addslashes($website) }}', '{{ $editUrl }}')">
                <img class="img-fluid img-icon" src="{{ asset('assets/admin/EditarIcon.png') }}">
            </button>
            <form action="{{ $deleteUrl }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta empresa?')">
                @csrf
                @method('DELETE')
                <x-btn-icon id="btn-delete" icon="{{ asset('assets/admin/BorrarIcon.png') }}" />
            </form>
        </div>

    </div>
</div>