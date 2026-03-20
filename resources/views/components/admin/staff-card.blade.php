@props(['user'])

@php
    $code = $user->llave_acceso ?? $user->name;
    $editUrl = route('admin.staff.update', $user);
    $deleteUrl = route('admin.staff.destroy', $user);
@endphp

<div class="expo-card card-c">

    <div class="card-data">

        <div class="card-info-name">
            <h3> {{ $code }} </h3>
        </div>
    </div>

    <div class="card-actions">

        <button id="btn-edit" class="btn btn-purple btn-icon" type="button"
            onclick="openEditModal('{{ addslashes($code) }}', '{{ $editUrl }}')">
            <img class="img-fluid img-icon" src="{{ asset('assets/admin/EditarIcon.png') }}">
        </button>
        <form action="{{ $deleteUrl }}" method="POST" onsubmit="return confirm('¿Seguro que deseas desactivar esta cuenta staff?')">
            @csrf
            @method('DELETE')
            <x-btn-icon id="btn-delete" icon="{{ asset('assets/admin/BorrarIcon.png') }}" />
        </form>
        
    </div>

</div>