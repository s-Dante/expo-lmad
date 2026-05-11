<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Staff</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/components/carrusel.css',
        'resources/css/admin/staff.css',
        'resources/js/components/load-portrait.js',
        'resources/js/admin/actions-staff.js',
        'resources/js/admin/carrusel.js'
    ]);

</head>

<body>

    <x-sidebar />

    <main>
        <h1>Staff</h1>

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

        <section class="section-teachers-create">
            <form action="{{ route('admin.staff.store') }}" method="POST">
                @csrf
                <container class="expo-card container-teachers-create">
                    <div class="div-teachers-create">

                        <div class="d-grid-gap teachers-data">
                            <span>Clave:</span>
                            <input type="text" id="staff-code" name="llave_acceso" class="input-c"
                                   value="{{ old('llave_acceso') }}" required>

                            <span>Contraseña:</span>
                            <input type="text" id="staff-pass" name="password" class="input-c"
                                   placeholder="Mínimo 6 caracteres" required>

                        </div>

                    </div>

                    <button class="btn">Registrar</button>

                </container>

            </form>
        </section>

        <section class="section-teachers-list">
            <div class="carousel-wrapper">
                <button class="carousel-btn btn-prev" aria-label="Anterior">&#10094;</button>

                <div class="container-carrusel-boxfade">

                    <div class="container-carrusel">

                        <div class="carousel-group">
                            @forelse ($staffUsers as $staffUser)
                                <x-admin.staff-card :user="$staffUser" />
                            @empty
                                <p style="color: var(--clr-gray); text-align: center; width: 100%;">
                                    No hay staff registrado aún.
                                </p>
                            @endforelse
                        </div>

                    </div>

                </div>

                <button class="carousel-btn btn-next" aria-label="Siguiente">&#10095;</button>
            </div>
        </section>

        <dialog id="edit-modal" class="dialog-edit">
            <form method="POST" id="edit-form" action="#" style="width: auto; display: flex; flex-grow: 1;">
                @method('PUT')
                @csrf

                <container class="expo-card container-teachers-create-d" style="position: relative;">

                    <!-- Botón de cerrar (X) -->
                    <button type="button" onclick="document.getElementById('edit-modal').close()"
                        style="position: absolute; top: 1.5rem; right: 1.5rem; background: transparent; border: none; color: var(--clr-white); font-size: 2rem; cursor: pointer; z-index: 50; line-height: 1; padding: 0.5rem;">
                        &times;
                    </button>

                    <div class="div-teachers-create-d">
                        <div class="d-grid-gap teachers-data">
                            <span>Clave:</span>
                            <input type="text" id="edit-staff-code" name="llave_acceso" class="input-c">

                            <span>Contraseña:</span>
                            <input type="text" id="edit-staff-pass" name="password" class="input-c"
                                   placeholder="Dejar vacío para mantener actual">
                        </div>
                    </div>

                    <button type="submit" class="btn" style="margin-top: 1.5rem;">Guardar Cambios</button>
                </container>
            </form>
        </dialog>

    </main>

</body>

</html>