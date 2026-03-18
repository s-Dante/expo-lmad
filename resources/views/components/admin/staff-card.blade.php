@props(['code', 'editUrl' => '#', 'deleteUrl' => '#'])

<div class="expo-card card-c">

    <div class="card-data">

        <div class="card-info-name">
            <h3> {{ $code }} </h3>
        </div>
    </div>

    <div class="card-actions">

        <button id="btn-edit" class="btn btn-purple btn-icon" type="button"
            onclick="openEditModal('{{ addslashes($code) }}')">
            <img class="img-fluid img-icon" src="{{ asset('assets/admin/EditarIcon.png') }}">
        </button>
        <form action="{{ $deleteUrl }}" method="POST">
            <x-btn-icon id="btn-delete" icon="{{ asset('assets/admin/BorrarIcon.png') }}" />
        </form>
        
    </div>

</div>