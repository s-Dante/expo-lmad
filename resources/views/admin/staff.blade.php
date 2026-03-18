<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        <section class="section-teachers-create">
            <form>
                <container class="expo-card container-teachers-create">
                    <div class="div-teachers-create">

                        <div class="d-grid-gap teachers-data">
                            <span>Clave:</span>
                            <input type="text" id="staff-code" name="staff-code" class="input-c">

                            <span>Contraseña:</span>
                            <input type="text" id="staff-pass" name="staff-pass" class="input-c">

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
                            <x-admin.staff-card code="1234567" />
                            <x-admin.staff-card code="1234567" />
                            <x-admin.staff-card code="1234567" />
                            <x-admin.staff-card code="1234567" />
                            <x-admin.staff-card code="1234567" />
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
                            <input type="text" id="edit-staff-code" name="staff-code" class="input-c">

                            <span>Contraseña:</span>
                            <input type="text" id="edit-staff-pass" name="staff-pass" class="input-c">
                        </div>
                    </div>

                    <button type="submit" class="btn" style="margin-top: 1.5rem;">Guardar Cambios</button>
                </container>
            </form>
        </dialog>

    </main>

</body>

</html>