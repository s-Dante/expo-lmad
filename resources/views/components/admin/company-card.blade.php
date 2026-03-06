@props(['name', 'tier', 'image', 'editUrl' => '#', 'deleteUrl' => '#'])

<div class="expo-card card-company">

    <div class="card-company-img">
        <div>
            </div>
        <img src="{{ $image }}" alt="{{ $name }}">

        <div class="card-company-info">
            <x-guest.sponsor-tier :tier="$tier" />
            <h3>{{ $name }}</h3>
            <div class="card-company-visitor">
                <p>Representante:</p>
                <span>Sin representate</span>
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