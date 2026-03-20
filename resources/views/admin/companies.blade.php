<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Empresas</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/admin/empresas-lista.css',
        'resources/js/components/load-portrait.js',
        'resources/js/admin/actions-empresas.js',
        'resources/js/admin/carrusel.js',
        'resources/css/components/carrusel.css'
    ]);

</head>

<body>

    <x-sidebar />

    <main>
        <h1>Empresas</h1>

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

        <section class="section-companies-create">
            <form action="{{ route('admin.patrocinadores.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <container class="expo-card container-companies-create">
                    <div class="div-companies-create">

                        <div class="d-grid-gap company-data">
                            <span>Nombre de la empresa:</span>
                            <input type="text" id="company-name" name="nombre" class="input-c"
                                   value="{{ old('nombre') }}" required>

                            <div class="checkbox-card">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" id="patrocinador" name="es_patrocinador" value="1"
                                           class="checkbox-input" {{ old('es_patrocinador') ? 'checked' : '' }}>
                                </div>
                                <div for="patrocinador" class="checkbox-label quit-highlight">
                                    <span class="checkbox-description">Patrocinador</span>
                                </div>
                            </div>

                            <div class="sponsor-data">
                                <container class="container-company-sponsor">

                                    <div class="d-grid-gap">
                                        <div>
                                            <span>Grado:</span>
                                            <select type="listbox" id="company-tier" name="tier"
                                                class="input-c">
                                                <option value="" disabled selected>Selecciona un grado</option>
                                                @foreach ($tiers as $value => $label)
                                                    <option value="{{ $value }}" {{ old('tier') === $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="d-grid-gap">
                                            <span>Link:</span>
                                            <input type="text" id="company-link" name="website_url" class="input-c"
                                                   value="{{ old('website_url') }}">
                                        </div>

                                    </div>

                                </container>
                            </div>
                        </div>

                        <div class="sponsor-data">
                            <container class="container-company-sponsor">

                                <div class="div-company-logo d-grid-gap">
                                    <span>Logo:</span>
                                    <span id="legend">Vista previa</span>
                                    <x-image-uploader-company />
                                </div>

                            </container>
                        </div>

                    </div>

                    <button class="btn">Registrar</button>

                </container>

            </form>
        </section>

        <section class="section-companies-list">
            <div class="carousel-wrapper">
                <button class="carousel-btn btn-prev" aria-label="Anterior">&#10094;</button>

                <div class="container-carrusel-boxfade">

                    <div class="container-carrusel">

                        <div class="carousel-group">

                            @forelse ($patrocinadores as $pat)
                                <x-admin.company-card :patrocinador="$pat" />
                            @empty
                                <p style="color: var(--clr-gray); text-align: center; width: 100%;">
                                    No hay empresas registradas aún.
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
                <container class="expo-card container-companies-create" style="position: relative; width: 80vw">
                    <!-- Botón de cerrar (X) -->
                    <button type="button" onclick="document.getElementById('edit-modal').close()"
                        style="position: absolute; top: 1.5rem; right: 1.5rem; background: transparent; border: none; color: var(--clr-white); font-size: 2rem; cursor: pointer; z-index: 50; line-height: 1; padding: 0.5rem;">
                        &times;
                    </button>

                    <div class="div-companies-create">
                        <div class="d-grid-gap company-data">
                            <span>Nombre de la empresa:</span>
                            <input type="text" id="edit-company-name" name="nombre" class="input-c" value="">

                            <div class="checkbox-card">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" id="edit-patrocinador" name="es_patrocinador" value="1"
                                        class="checkbox-input">
                                </div>
                                <label for="edit-patrocinador" class="checkbox-label quit-highlight">
                                    <span class="checkbox-description">Patrocinador</span>
                                </label>
                            </div>

                            <div class="sponsor-data">
                                <container class="container-company-sponsor">
                                    <div class="d-grid-gap">
                                        <div>
                                            <span>Grado:</span>
                                            <select type="listbox" id="edit-company-tier" name="tier"
                                                class="input-c">
                                                <option value="" disabled selected>Selecciona un grado</option>
                                                @foreach ($tiers as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </container>
                            </div>
                        </div>

                        <div class="sponsor-data">
                            <container class="container-company-sponsor">
                                <div class="div-company-logo d-grid-gap">
                                    <span>Logo Actual:</span>
                                    <img id="edit-current-logo" src="" alt="Logo" class="img-fluid sponsor"
                                        style="max-width: 6rem; margin: auto; display: none;">
                                    <span id="edit-no-logo"
                                        style="color: var(--clr-gray); font-size: 0.7rem; display: block;">Sin logo
                                        previo</span>

                                    <span style="margin-top: 1rem;">Actualizar Logo:</span>
                                    <x-image-uploader-company />
                                </div>
                            </container>
                        </div>
                    </div>

                    <button type="submit" class="btn" style="margin-top: 1.5rem;">Guardar Cambios</button>
                </container>
            </form>
        </dialog>

    </main>


</body>

</html>