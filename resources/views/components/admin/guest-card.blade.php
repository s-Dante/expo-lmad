@props(['conferencista'])

@php
    $fullName = $conferencista->nombre . ' ' . $conferencista->apellido_paterno . ($conferencista->apellido_materno ? ' ' . $conferencista->apellido_materno : '');
    $empresa = $conferencista->empresa ?? 'Sin empresa';
    $cargo = $conferencista->cargo ?? '';
    $email = $conferencista->email ?? '';
    $editUrl = route('admin.conferencistas.update', $conferencista);
    $deleteUrl = route('admin.conferencistas.destroy', $conferencista);
@endphp

<div class="expo-card card-c">

    <div class="card-data">

        <div class="card-info-name">
            <h3>{{ $fullName }}</h3>
            <div class="card-visitor">
                <p>Empresa:</p>
                <span>{{ $empresa }}</span>
                @if ($cargo)
                    <p style="margin-top: 0.3rem;">Cargo: <span>{{ $cargo }}</span></p>
                @endif
            </div>
        </div>
    </div>

    <div class="card-actions">

        <button id="btn-edit-{{ $conferencista->id }}" class="btn btn-purple btn-icon" type="button"
            onclick="openEditModal('{{ addslashes($conferencista->nombre) }}', '{{ addslashes($conferencista->apellido_paterno) }}', '{{ addslashes($conferencista->apellido_materno ?? '') }}', '{{ addslashes($email) }}', '{{ addslashes($conferencista->empresa ?? '') }}', '{{ addslashes($cargo) }}', '{{ $editUrl }}')">
            <img class="img-fluid img-icon" src="{{ asset('assets/admin/EditarIcon.png') }}">
        </button>
        <form action="{{ $deleteUrl }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este conferencista?')">
            @csrf
            @method('DELETE')
            <x-btn-icon id="btn-delete-{{ $conferencista->id }}" icon="{{ asset('assets/admin/BorrarIcon.png') }}" />
        </form>
    </div>

</div>