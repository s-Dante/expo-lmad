@props(['name', 'date', 'type', 'time_start', 'time_end', 'editUrl' => '#', 'deleteUrl' => '#'])

<div class="expo-card card-c">

    <div class="card-data">

        <div class="card-info-name">

            <h3>{{ $name }}</h3>
            <div class="card-visitor">
                <p> {{ $type }} </p>

                <p> Hora inicio: <span>{{ $time_start }} hrs</span> </p>
                <p> Hora salida: <span>{{ $time_end }} hrs</span> </p>

                <p> {{ $date }} </p>

            </div>

        </div>

        <div class="card-actions">

            <button id="btn-edit" class="btn btn-purple btn-icon" type="button"
                onclick="openEditModal('{{ addslashes($name) }}', '{{ addslashes($type) }}', '{{ addslashes($time_start) }}', '{{ addslashes($time_end) }}', '{{ addslashes($date) }}', '{{ $editUrl }}')">
                <img class="img-fluid img-icon" src="{{ asset('assets/admin/EditarIcon.png') }}">
            </button>
            <form action="{{ $deleteUrl }}" method="POST">
                <x-btn-icon id="btn-delete" icon="{{ asset('assets/admin/BorrarIcon.png') }}" />
            </form>
        </div>

    </div>

</div>