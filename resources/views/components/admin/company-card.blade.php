@props(['patrocinador'])

@php
    $name = $patrocinador->nombre;
    $tier = $patrocinador->tier;

    $hasRealLogo = $patrocinador->logo_url && (str_starts_with($patrocinador->logo_url, 'http') || file_exists(storage_path('app/public/' . $patrocinador->logo_url)));

    $image = $hasRealLogo
        ? (str_starts_with($patrocinador->logo_url, 'http') ? $patrocinador->logo_url : asset('storage/' . $patrocinador->logo_url))
        : null;

    $isSponsor = $patrocinador->es_patrocinador && $tier && $tier !== 'Ninguno';
    $website = $patrocinador->website_url ?? '';
    $editUrl = route('admin.patrocinadores.update', $patrocinador);
    $deleteUrl = route('admin.patrocinadores.destroy', $patrocinador);
@endphp

<div class="expo-card card-c">
    <div class="card-data">

        {{-- Contenido principal que crece para ocupar el espacio --}}
        <div class="card-main-content">
            @if ($image)
                <div class="card-company-logo">
                    <img src="{{ $image }}" alt="{{ $name }}">
                </div>
            @endif

            <div class="{{ $isSponsor ? 'card-company-info-sponsor' : 'card-info-name' }}">
                @if ($isSponsor)
                    <x-guest.sponsor-tier :tier="$tier" />
                @endif

                <h3>{{ $name }}</h3>

                <div class="card-visitor">
                    <p>Web:</p>
                    {{-- Truncar URL larga para que no rompa el layout --}}
                    @if($website)
                        <span title="{{ $website }}">
                            {{ strlen($website) > 35 ? substr($website, 0, 35) . '...' : $website }}
                        </span>
                    @else
                        <span>Sin sitio web</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Acciones siempre al fondo --}}
        <div class="card-actions">
            <button id="btn-edit" class="btn btn-purple btn-icon" type="button"
                onclick="openEditModal('{{ $patrocinador->id }}', '{{ addslashes($name) }}', '{{ $tier ?? '' }}', '{{ addslashes($image ?? '') }}', '{{ addslashes($website) }}', '{{ $editUrl }}')">
                <img class="img-fluid img-icon" src="{{ asset('assets/admin/EditarIcon.png') }}">
            </button>
            <form action="{{ $deleteUrl }}" method="POST"
                onsubmit="return confirm('¿Seguro que deseas eliminar esta empresa?')">
                @csrf
                @method('DELETE')
                <x-btn-icon id="btn-delete" icon="{{ asset('assets/admin/BorrarIcon.png') }}" />
            </form>
        </div>

    </div>
</div>