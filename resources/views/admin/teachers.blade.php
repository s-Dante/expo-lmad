<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Maestros</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/admin/teachers.css',
        'resources/css/components/carrusel.css',
        'resources/js/components/load-portrait.js',
        'resources/js/admin/actions-teachers.js',
        'resources/js/admin/carrusel.js'

    ]);

</head>

<body>

    <x-sidebar />

    <main>
        <h1>Maestros</h1>

        <section class="section-teachers-create">
            <form>
                <container class="expo-card container-teachers-create">
                    <div class="div-teachers-create">

                        <div class="d-grid-gap teachers-data">
                            <span>Nombre del maestro:</span>
                            <input type="text" id="teacher-name" name="teacher-name" class="input-c">

                            <span>Correo del maestro:</span>
                            <input type="text" id="teacher-email" name="teacher-email" class="input-c">

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
                            <x-admin.teacher-card name="Abigail Palacios" user="Abi" pass="rosa" email="alberta.palaciosgrz@uanl.edu.mx" />
                            <x-admin.teacher-card name="Abigail Palacios" user="Abi" pass="rosa" email="alberta.palaciosgrz@uanl.edu.mx" />
                            <x-admin.teacher-card name="Abigail Palacios" user="Abi" pass="rosa" email="alberta.palaciosgrz@uanl.edu.mx" />
                            <x-admin.teacher-card name="Abigail Palacios" user="Abi" pass="rosa" email="alberta.palaciosgrz@uanl.edu.mx" />
                            <x-admin.teacher-card name="Abigail Palacios" user="Abi" pass="rosa" email="alberta.palaciosgrz@uanl.edu.mx" />
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
                            <span>Nombre del maestro:</span>
                            <input type="text" id="edit-teacher-name" name="teacher-name" class="input-c">

                            <span>Correo del maestro:</span>
                            <input type="email" id="edit-teacher-email" name="teacher-email" class="input-c">

                            <span>Usuario:</span>
                            <input type="text" id="edit-teacher-user" name="teacher-user" class="input-c">

                            <span>Contraseña:</span>
                            <input type="text" id="edit-teacher-pass" name="teacher-pass" class="input-c">
                        </div>
                    </div>

                    <button type="submit" class="btn" style="margin-top: 1.5rem;">Guardar Cambios</button>
                </container>
            </form>
        </dialog>

    </main>

</body>

</html>