@props(['name', 'tier' => null, 'image' => null, 'representative' => 'Sin representante', 'editUrl' => '#', 'deleteUrl' => '#'])

<div class="expo-card card-company">

    <div class="card-company-data">
        @if ($image)
            <div class="card-company-logo">
                <img src="{{ $image }}" alt="{{ $name }}">
            </div>
        @endif

        @if ($tier)
            <div class="card-company-info-sponsor">
                <x-guest.sponsor-tier :tier="$tier" />
        @else
                <div class="card-company-info">
            @endif
                <h3>{{ $name }}</h3>
                <div class="card-company-visitor">
                    <p>Representante:</p>
                    <span>{{ $representative }}</span>
                </div>
            </div>
        </div>

        <div class="card-company-actions">
            <x-btn-icon id="btn-edit" icon="{{ asset('assets/admin/EditarIcon.png') }}" />
            <form action="{{ $deleteUrl }}" method="POST">
                <x-btn-icon id="btn-delete" icon="{{ asset('assets/admin/BorrarIcon.png') }}" />
            </form>
        </div>

    </div>