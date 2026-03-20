@props(['profesor'])

@php
    $fullName = $profesor->nombre . ' ' . $profesor->apellido_paterno . ($profesor->apellido_materno ? ' ' . $profesor->apellido_materno : '');
    $email = $profesor->usuario->email ?? $profesor->email ?? 'Sin correo';
    $user = $profesor->usuario->name ?? $profesor->numero_empleado;
    $editUrl = route('admin.teachers.update', $profesor);
    $deleteUrl = route('admin.teachers.destroy', $profesor);
@endphp

<div class="expo-card card-c">

    <div class="card-data">

        <div class="card-info-name">
            <h3>{{ $fullName }}</h3>
            <div class="card-visitor">
                <p>Correo:</p>
                <span>{{ $email }}</span>
                <p>No. Empleado: <span>{{ $profesor->numero_empleado }}</span></p>
            </div>
        </div>
    </div>

    <div class="card-actions">

        <button id="btn-edit-{{ $profesor->id }}" class="btn btn-purple btn-icon" type="button"
            onclick="openEditModal('{{ addslashes($fullName) }}', '{{ addslashes($email) }}', '{{ $editUrl }}')">
            <img class="img-fluid img-icon" src="{{ asset('assets/admin/EditarIcon.png') }}">
        </button>
        <form action="{{ $deleteUrl }}" method="POST" onsubmit="return confirm('¿Seguro que deseas revocar la cuenta de {{ addslashes($fullName) }}?')">
            @csrf
            @method('DELETE')
            <x-btn-icon id="btn-delete-{{ $profesor->id }}" icon="{{ asset('assets/admin/BorrarIcon.png') }}" />
        </form>

    </div>

</div>