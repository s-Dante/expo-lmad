@props(['name', 'tier' => null, 'image' => null, 'representative' => 'Sin representante', 'editUrl' => '#', 'deleteUrl' => '#'])

<div class="expo-card card-c">

    <div class="card-data">

        <div class="card-info-name">
            @if ($tier)

                <x-guest.sponsor-tier :tier="$tier" />
            @endif
            <h3> {{ $representative }} </h3>
            <div class="card-visitor">
                <p>Empresa:</p>
                <span> {{ $name }} </span>
            </div>
        </div>
    </div>

    <div class="card-actions">

        <button id="btn-edit" class="btn btn-purple btn-icon" type="button"
            onclick="openEditModal('{{ addslashes($name) }}', '{{ addslashes($representative) }}', '{{ $editUrl }}')">
            <img class="img-fluid img-icon" src="{{ asset('assets/admin/EditarIcon.png') }}">
        </button>
        <form action="{{ $deleteUrl }}" method="POST">
            <x-btn-icon id="btn-delete" icon="{{ asset('assets/admin/BorrarIcon.png') }}" />
        </form>
    </div>

</div>