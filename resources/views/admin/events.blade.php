<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Eventos</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/components/carrusel.css',
        'resources/css/admin/events.css',
        'resources/js/components/load-portrait.js',
        'resources/js/admin/actions-events.js',
        'resources/js/admin/carrusel.js'


    ]);

</head>

<body>

    <x-sidebar />

    <main>
        <h1>Eventos</h1>

        {{-- Mensajes flash --}}
        @if (session('success'))
            <div class="alert-success" style="background: rgba(46,204,113,0.15); color: #2ecc71; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; text-align: center;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-error" style="background: rgba(231,76,60,0.15); color: #e74c3c; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <ul style="margin: 0; padding-left: 1.2rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="section-events-create">
            <form action="{{ route('admin.eventos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <container class="expo-card container-events-create">
                    <div class="div-events-create">

                        <div class="d-grid-gap event-data">

                            <span>Nombre del evento:</span>
                            <input type="text" id="event-name" name="titulo" class="input-c"
                                   value="{{ old('titulo') }}" required>

                            <span>Tipo:</span>
                            <select id="event-type" name="tipo" class="input-c" required>
                                <option value="" disabled selected>Selecciona un tipo</option>
                                @foreach ($tiposEvento as $value => $label)
                                    <option value="{{ $value }}" {{ old('tipo') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="div-event-time">

                                <div>
                                    <span>Fecha y hora inicio:</span>
                                    <input type="datetime-local" id="event-date-start" name="fecha_inicio_evento"
                                           class="input-c" value="{{ old('fecha_inicio_evento') }}" required>

                                    <span>Fecha y hora fin:</span>
                                    <input type="datetime-local" id="event-date-end" name="fecha_fin_evento"
                                           class="input-c" value="{{ old('fecha_fin_evento') }}" required>

                                    <span>Ubicación:</span>
                                    <input type="text" id="event-location" name="ubicacion_evento"
                                           class="input-c" value="{{ old('ubicacion_evento') }}">

                                    <span>Capacidad:</span>
                                    <input type="number" id="event-capacity" name="capacidad"
                                           class="input-c" value="{{ old('capacidad') }}" min="1">
                                </div>

                                <div>
                                    <span>Conferencistas:</span>
                                    <select id="event-guest" name="conferencistas[]" class="input-c" size="5" multiple>
                                        @foreach ($conferencistas as $conf)
                                            <option value="{{ $conf->id }}">
                                                {{ $conf->nombre }} {{ $conf->apellido_paterno }}
                                                @if($conf->empresa) ({{ $conf->empresa }}) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="div-event-logo d-grid-gap">
                            <span>Imagen del evento:</span>
                            <x-image-uploader-event />
                        </div>

                    </div>

                    <button class="btn">Registrar</button>

                </container>

            </form>
        </section>

        <section class="section-events-list">
            <div class="carousel-wrapper">
                <button class="carousel-btn btn-prev" aria-label="Anterior">&#10094;</button>

                <div class="container-carrusel-boxfade">

                    <div class="container-carrusel">

                        <div class="carousel-group">
                            @forelse ($eventos as $evento)
                                <x-admin.event-card :evento="$evento" />
                            @empty
                                <p style="color: var(--clr-gray); text-align: center; width: 100%;">
                                    No hay eventos registrados aún.
                                </p>
                            @endforelse
                        </div>

                    </div>

                </div>

                <button class="carousel-btn btn-next" aria-label="Siguiente">&#10095;</button>
            </div>
        </section>

        <!-- Modal de Edición Dinámico -->
        <dialog id="edit-modal" class="dialog-edit">
            <form method="POST" id="edit-form" action="#" enctype="multipart/form-data" style="width: auto; display: flex; flex-grow: 1;">
                @method('PUT')
                @csrf

                <container class="expo-card container-events-create" style="position: relative; width: 80vw">
                    <!-- Botón de cerrar (X) -->
                    <button type="button" onclick="document.getElementById('edit-modal').close()"
                        style="position: absolute; top: 1.5rem; right: 1.5rem; background: transparent; border: none; color: var(--clr-white); font-size: 2rem; cursor: pointer; z-index: 50; line-height: 1; padding: 0.5rem;">
                        &times;
                    </button>

                    <div class="div-events-create">

                        <div class="d-grid-gap event-data">

                            <span>Nombre del evento:</span>
                            <input type="text" id="edit-event-name" name="titulo" class="input-c">

                            <span>Tipo:</span>
                            <select id="edit-event-type" name="tipo" class="input-c">
                                <option value="" disabled>Selecciona un tipo</option>
                                @foreach ($tiposEvento as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>

                            <div class="div-event-time">

                                <div>
                                    <span>Fecha y hora inicio:</span>
                                    <input type="datetime-local" id="edit-event-date-start" name="fecha_inicio_evento" class="input-c">

                                    <span>Fecha y hora fin:</span>
                                    <input type="datetime-local" id="edit-event-date-end" name="fecha_fin_evento" class="input-c">

                                    <span>Ubicación:</span>
                                    <input type="text" id="edit-event-location" name="ubicacion_evento" class="input-c">

                                    <span>Capacidad:</span>
                                    <input type="number" id="edit-event-capacity" name="capacidad" class="input-c" min="1">
                                </div>

                                <div>
                                    <span>Conferencistas:</span>
                                    <select id="edit-event-guest" name="conferencistas[]" class="input-c" size="5" multiple>
                                        @foreach ($conferencistas as $conf)
                                            <option value="{{ $conf->id }}">
                                                {{ $conf->nombre }} {{ $conf->apellido_paterno }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="div-event-logo d-grid-gap">
                            <span>Imagen del evento:</span>
                            <x-image-uploader-event />
                        </div>

                    </div>

                    <button type="submit" class="btn" style="margin-top: 1.5rem;">Guardar Cambios</button>
                </container>
            </form>
        </dialog>

    </main>


</body>

</html>