<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Maestros</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/admin/teachers.css',
        'resources/css/components/carrusel.css',
        'resources/js/components/load-portrait.js',
        'resources/js/admin/teachers/actions-teachers.js',
        'resources/js/admin/carrusel.js'
    ]);
</head>

<body>

    <x-sidebar />

    <main>
        <h1>Maestros</h1>

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
            <form action="{{ route('admin.teachers.store') }}" method="POST">
                @csrf
                <container class="expo-card container-teachers-create">
                    <div class="div-teachers-create">

                        <div class="d-grid-gap teachers-data">
                            <span>Profesor del padrón:</span>
                            <select id="teacher-select" name="profesor_id" class="input-c" required
                                    onchange="prefillEmail(this)">
                                <option value="" disabled selected>Selecciona un profesor</option>
                                @foreach ($profesoresSinCuenta as $prof)
                                    <option value="{{ $prof->id }}"
                                            data-email="{{ $prof->email ?? '' }}"
                                            data-nombre="{{ $prof->apellido_paterno }}"
                                            data-empleado="{{ $prof->numero_empleado }}"
                                            {{ old('profesor_id') == $prof->id ? 'selected' : '' }}>
                                        {{ $prof->nombre }} {{ $prof->apellido_paterno }} {{ $prof->apellido_materno ?? '' }}
                                        ({{ $prof->numero_empleado }})
                                    </option>
                                @endforeach
                            </select>

                            <span>Correo del maestro:</span>
                            <input type="email" id="teacher-email" name="email" class="input-c"
                                   value="{{ old('email') }}" required>

                            <span>Contraseña:</span>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <input type="text" id="teacher-pass" name="password" class="input-c"
                                       placeholder="Se genera automáticamente" required>
                                <button type="button" class="btn" style="white-space: nowrap; padding: 0.5rem 1rem; font-size: 0.8rem;"
                                        onclick="generatePassword()">Generar</button>
                            </div>

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
                            @forelse ($profesoresConCuenta as $prof)
                                <x-admin.teacher-card :profesor="$prof" />
                            @empty
                                <p style="color: var(--clr-gray); text-align: center; width: 100%;">
                                    No hay profesores con cuenta registrada aún.
                                </p>
                            @endforelse
                        </div>

                    </div>

                </div>

                <button class="carousel-btn btn-next" aria-label="Siguiente">&#10095;</button>
            </div>
        </section>

        {{-- Modal: Gestionar Materias --}}
        <dialog id="materias-modal" class="dialog-edit">
            <form method="POST" id="materias-form" action="#" style="width: auto; display: flex; flex-grow: 1;">
                @csrf

                <container class="expo-card container-teachers-create-d" style="position: relative;">

                    <button type="button" onclick="document.getElementById('materias-modal').close()"
                        style="position: absolute; top: 1.5rem; right: 1.5rem; background: transparent; border: none; color: var(--clr-white); font-size: 2rem; cursor: pointer; z-index: 50; line-height: 1; padding: 0.5rem;">
                        &times;
                    </button>

                    <h3 id="materias-modal-title" style="margin-bottom: 1rem; padding-right: 3rem;">Materias de Profesor</h3>

                    <div id="materias-list"
                         style="max-height: 55vh; overflow-y: auto; display: flex; flex-direction: column; gap: 0.5rem; padding-right: 0.5rem;">
                        @foreach ($todasLasMaterias as $materia)
                            <label style="display: flex; align-items: flex-start; gap: 0.6rem; cursor: pointer; padding: 0.4rem 0.5rem; border-radius: 6px; transition: background 0.15s;"
                                   onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                                <input type="checkbox"
                                       name="materia_ids[]"
                                       value="{{ $materia->id }}"
                                       class="materia-checkbox"
                                       style="margin-top: 0.2rem; accent-color: var(--clr-purple, #a855f7); flex-shrink: 0;">
                                <span style="line-height: 1.3;">
                                    <strong>{{ $materia->clave }}</strong> — {{ $materia->nombre }}
                                    @if ($materia->planAcademico)
                                        <small style="color: var(--clr-gray, #9ca3af); display: block;">{{ $materia->planAcademico->nombre }}</small>
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>

                    <div style="display: flex; gap: 1rem; margin-top: 1.5rem; align-items: center;">
                        <button type="submit" class="btn">Guardar Materias</button>
                        <small id="materias-count-label" style="color: var(--clr-gray, #9ca3af);"></small>
                    </div>
                </container>
            </form>
        </dialog>

        {{-- Modal: Editar cuenta --}}
        <dialog id="edit-modal" class="dialog-edit">
            <form method="POST" id="edit-form" action="#" style="width: auto; display: flex; flex-grow: 1;">
                @method('PUT')
                @csrf

                <container class="expo-card container-teachers-create-d" style="position: relative;">

                    <button type="button" onclick="document.getElementById('edit-modal').close()"
                        style="position: absolute; top: 1.5rem; right: 1.5rem; background: transparent; border: none; color: var(--clr-white); font-size: 2rem; cursor: pointer; z-index: 50; line-height: 1; padding: 0.5rem;">
                        &times;
                    </button>

                    <div class="div-teachers-create-d">
                        <div class="d-grid-gap teachers-data">
                            <span>Correo del maestro:</span>
                            <input type="email" id="edit-teacher-email" name="email" class="input-c">

                            <span>Nueva contraseña (dejar vacío para no cambiar):</span>
                            <input type="password" id="edit-teacher-pass" name="password" class="input-c"
                                   placeholder="Dejar vacío para mantener actual">
                        </div>
                    </div>

                    <button type="submit" class="btn" style="margin-top: 1.5rem;">Guardar Cambios</button>
                </container>
            </form>
        </dialog>

    </main>

    <script>
        function prefillEmail(select) {
            const selectedOption = select.options[select.selectedIndex];
            const email = selectedOption.getAttribute('data-email');
            const emailInput = document.getElementById('teacher-email');
            if (email) {
                emailInput.value = email;
            } else {
                emailInput.value = '';
                emailInput.focus();
            }
        }

        function generatePassword() {
            const select = document.getElementById('teacher-select');
            const selectedOption = select.options[select.selectedIndex];

            if (!selectedOption || !selectedOption.value) {
                alert('Primero selecciona un profesor.');
                return;
            }

            const apellido  = (selectedOption.getAttribute('data-nombre') || 'PROF').toUpperCase();
            const empleado  = selectedOption.getAttribute('data-empleado') || '0000';

            // Formato: Apellido + NumEmpleado + ! (fácil de comunicar, único por profesor)
            const password = apellido + empleado + '!';
            document.getElementById('teacher-pass').value = password;
        }
    </script>

</body>

</html>