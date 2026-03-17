@props(['email', 'pass', 'user', 'name', 'editUrl' => '#', 'deleteUrl' => '#'])

<div class="expo-card card-c">

    <div class="card-data">

        <div class="card-info-name">
            <h3> {{ $name }} </h3>
            <div class="card-visitor">
                <p>Correo:</p>
                <span> {{ $email }} </span>
                <p>Usuario: <span> {{ $user }} </span> </p>
                <p>Contraseña: <span> {{ $pass }} </span> </p>
            </div>
        </div>
    </div>

    <div class="card-actions">

        <button id="btn-edit" class="btn btn-purple btn-icon" type="button"
            onclick="openEditModal('{{ addslashes($name) }}', '{{ addslashes($email) }}', '{{ addslashes($user) }}', '{{ addslashes($pass) }}', '{{ $editUrl }}')">
            <img class="img-fluid img-icon" src="{{ asset('assets/admin/EditarIcon.png') }}">
        </button>
        <form action="{{ $deleteUrl }}" method="POST">
            <x-btn-icon id="btn-delete" icon="{{ asset('assets/admin/BorrarIcon.png') }}" />
        </form>
        
    </div>

</div>