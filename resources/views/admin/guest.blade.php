<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Empresas</title>

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
        <h1>Eventos</h1>

        <section class="section-guest-create">
            <form>
                <container class="expo-card container-guest-create">
                    <div class="div-guest-create">

                        <div class="d-grid-gap guest-data">
                            <span>Nombre del invitado:</span>
                            <input type="text" id="company-name" name="company-name" class="input-c">

                            <span>Empresa:</span>
                            <select type="listbox" id="company-name" name="company-name" class="input-c">
                                <option value="" disabled selected>Selecciona una empresa</option>
                                <option>OXXO</option>
                                <option>Epic Games</option>
                                <option>Coca Cola</option>
                                <option>Accenture</option>
                            </select>

                        </div>

                    </div>

                    <button class="btn">Registrar</button>

                </container>

            </form>
        </section>

        <section class="section-guest-list">
            <div class="carousel-wrapper">
                <button class="carousel-btn btn-prev" aria-label="Anterior">&#10094;</button>

                <div class="container-carrusel-boxfade">

                    <div class="container-carrusel">

                        <div class="carousel-group">
                            <x-admin.guest-card name="OXXO" representative="Jane Doe" />
                            <x-admin.guest-card image="{{asset('assets/guest/sponsor(1).svg')}}" name="Epic Games"
                                tier="Titanium" representative="Jane Doe" />
                            <x-admin.guest-card image="{{asset('assets/guest/sponsor(2).svg')}}" name="Coca Cola"
                                tier="Gold" representative="Jane Doe" />
                            <x-admin.guest-card image="{{asset('assets/guest/sponsor(3).svg')}}" name="Accenture"
                                tier="Bronze" representative="Jane Doe" />
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

                <container class="expo-card container-guest-create-d" style="position: relative;">

                    <!-- Botón de cerrar (X) -->
                    <button type="button" onclick="document.getElementById('edit-modal').close()"
                        style="position: absolute; top: 1.5rem; right: 1.5rem; background: transparent; border: none; color: var(--clr-white); font-size: 2rem; cursor: pointer; z-index: 50; line-height: 1; padding: 0.5rem;">
                        &times;
                    </button>

                    <div class="div-guest-create-d">

                        <div class="d-grid-gap guest-data">
                            <span>Nombre del invitado:</span>
                            <input type="text" id="edit-guest-name" name="guest-name" class="input-c">

                            <span>Empresa:</span>
                            <select type="listbox" id="edit-guest-company" name="company-name" class="input-c">
                                <option value="" disabled selected>Selecciona una empresa</option>
                                <option value="OXXO">OXXO</option>
                                <option value="Epic Games">Epic Games</option>
                                <option value="Coca Cola">Coca Cola</option>
                                <option value="Accenture">Accenture</option>
                            </select>

                        </div>
                    </div>

                    <button type="submit" class="btn" style="margin-top: 1.5rem;">Guardar Cambios</button>
                </container>
            </form>
        </dialog>

    </main>

</body>

</html>