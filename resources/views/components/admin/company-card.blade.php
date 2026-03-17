@props(['name', 'tier' => null, 'image' => null, 'representative' => 'Sin representante', 'editUrl' => '#', 'deleteUrl' => '#'])

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
                    <p>Representante:</p>
                    <span>{{ $representative }}</span>
                </div>
            </div>
        </div>

        <div class="card-actions">

            <button id="btn-edit" class="btn btn-purple btn-icon" type="button"
                onclick="openEditModal('{{ addslashes($name) }}', '{{ addslashes($representative) }}'">>
                <img class="img-fluid img-icon" src="{{ asset('assets/admin/EditarIcon.png') }}">
            </button>
            <form action="{{ $deleteUrl }}" method="POST">
                <x-btn-icon id="btn-delete" icon="{{ asset('assets/admin/BorrarIcon.png') }}" />
            </form>
        </div>

    </div>