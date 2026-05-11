<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Conferencistas</title>

    @vite([
    'resources/css/guest/template.css',
    'resources/css/admin/guest.css',
    'resources/css/components/carrusel.css',
    'resources/js/components/load-portrait.js',
    'resources/js/admin/actions-guest.js',
    'resources/js/admin/carrusel.js'
    ]);
</head>

<body>

    <x-sidebar />

    <main>
        <h1>Conferencistas</h1>

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

        <section class="section-guest-create">
            <form action="{{ route('admin.conferencistas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <container class="expo-card container-guest-create">
                    <div class="div-guest-create">

                        <div class="d-grid-gap guest-data">
                            <span>Nombre:</span>
                            <input type="text" id="guest-nombre" name="nombre" class="input-c"
                                value="{{ old('nombre') }}">

                            <span>Apellido Paterno:</span>
                            <input type="text" id="guest-apellido-p" name="apellido_paterno" class="input-c"
                                value="{{ old('apellido_paterno') }}">

                            <span>Apellido Materno:</span>
                            <input type="text" id="guest-apellido-m" name="apellido_materno" class="input-c"
                                value="{{ old('apellido_materno') }}">

                            <span>Nickname (Sobrenombre):</span>
                            <input type="text" id="guest-nickname" name="nickname" class="input-c"
                                value="{{ old('nickname') }}">

                            <span>Email:</span>
                            <input type="email" id="guest-email" name="email" class="input-c"
                                value="{{ old('email') }}">

                            <span>Empresa (opcional):</span>
                            <input type="text" id="guest-empresa" name="empresa" class="input-c"
                                value="{{ old('empresa') }}" placeholder="Nombre de la empresa">

                            <span>Cargo:</span>
                            <input type="text" id="guest-cargo" name="cargo" class="input-c"
                                value="{{ old('cargo') }}">

                        </div>

                    </div>

                    <button type="submit" class="btn">Registrar</button>

                </container>

            </form>
        </section>

        <section class="section-guest-list">
            <div class="carousel-wrapper">
                <button class="carousel-btn btn-prev" aria-label="Anterior">&#10094;</button>

                <div class="container-carrusel-boxfade">

                    <div class="container-carrusel">

                        <div class="carousel-group">
                            @forelse ($conferencistas as $conf)
                            <x-admin.guest-card :conferencista="$conf" />
                            @empty
                            <p style="color: var(--clr-gray); text-align: center; width: 100%;">
                                No hay conferencistas registrados aún.
                            </p>
                            @endforelse
                        </div>

                    </div>

                </div>

                <button class="carousel-btn btn-next" aria-label="Siguiente">&#10095;</button>
            </div>
        </section>

        <dialog id="edit-modal" class="dialog-edit">
            <form method="POST" id="edit-form" action="#" enctype="multipart/form-data" style="width: auto; display: flex; flex-grow: 1;">
                @method('PUT')
                @csrf

                <container class="expo-card container-guest-create-d" style="position: relative;">

                    <button type="button" onclick="document.getElementById('edit-modal').close()"
                        style="position: absolute; top: 1.5rem; right: 1.5rem; background: transparent; border: none; color: var(--clr-white); font-size: 2rem; cursor: pointer; z-index: 50; line-height: 1; padding: 0.5rem;">
                        &times;
                    </button>

                    <div class="div-guest-create-d">

                        <div class="d-grid-gap guest-data">
                            <span>Nombre:</span>
                            <input type="text" id="edit-guest-nombre" name="nombre" class="input-c">

                            <span>Apellido Paterno:</span>
                            <input type="text" id="edit-guest-apellido-p" name="apellido_paterno" class="input-c">

                            <span>Apellido Materno:</span>
                            <input type="text" id="edit-guest-apellido-m" name="apellido_materno" class="input-c">

                            <span>Nickname (Sobrenombre):</span>
                            <input type="text" id="edit-guest-nickname" name="nickname" class="input-c">

                            <span>Email:</span>
                            <input type="email" id="edit-guest-email" name="email" class="input-c">

                            <span>Empresa:</span>
                            <input type="text" id="edit-guest-empresa" name="empresa" class="input-c">

                            <span>Cargo:</span>
                            <input type="text" id="edit-guest-cargo" name="cargo" class="input-c">

                        </div>
                    </div>

                    <button type="submit" class="btn" style="margin-top: 1.5rem;">Guardar Cambios</button>
                </container>
            </form>
        </dialog>

    </main>

</body>

</html>