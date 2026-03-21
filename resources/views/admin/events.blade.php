<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Eventos</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/components/carrusel.css',
        'resources/css/admin/events.css',
        'resources/js/components/load-portrait.js',
        'resources/js/admin/events/actions-events.js',
        'resources/js/admin/carrusel.js'


    ]);

</head>

<body>

    <x-sidebar />

    <main>
        <h1>Eventos</h1>

        <section class="section-events-create">
            <form>
                <container class="expo-card container-events-create">
                    <div class="div-events-create">

                        <div class="d-grid-gap event-data">

                            <span>Nombre del evento:</span>
                            <input type="text" id="event-name" name="event-name" class="input-c">

                            <span>Tipo:</span>
                            <input type="text" id="event-type" name="event-type" class="input-c">

                            <div class="div-event-time">

                                <div>
                                    <span>Fecha:</span>
                                    <input type="text" id="event-date" name="event-date" class="input-c">

                                    <span>Hora inicio:</span>
                                    <input type="text" id="event-time-start" name="event-time-start" class="input-c">

                                    <span>Hora fin:</span>
                                    <input type="text" id="event-time-end" name="event-time-end" class="input-c">
                                </div>

                                <div>
                                    <span>Invitados:</span>
                                    <select id="event-guest" name="event-guest" class="input-c" size="5">
                                        <option value="Guest 1">Guest 1</option>
                                        <option value="Guest 2">Guest 2</option>
                                        <option value="Guest 3">Guest 3</option>
                                        <option value="Guest 4">Guest 4</option>
                                        <option value="Guest 5">Guest 5</option>
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
                            <x-admin.event-card name="Unreal Engine" type="Conferencia" time_start="12:00"
                                time_end="1:00" date="23-05-2026" />
                            <x-admin.event-card name="Unreal Engine" type="Conferencia" time_start="12:00"
                                time_end="1:00" date="23-05-2026" />
                            <x-admin.event-card name="Unreal Engine" type="Conferencia" time_start="12:00"
                                time_end="1:00" date="23-05-2026" />
                        </div>

                    </div>

                </div>

                <button class="carousel-btn btn-next" aria-label="Siguiente">&#10095;</button>
            </div>
        </section>

        <!-- Modal de Edición Dinámico -->
        <dialog id="edit-modal" class="dialog-edit">
            <form method="POST" id="edit-form" action="#" style="width: auto; display: flex; flex-grow: 1;">
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
                            <input type="text" id="edit-event-name" name="event-name" class="input-c">

                            <span>Tipo:</span>
                            <input type="text" id="edit-event-type" name="event-type" class="input-c">

                            <div class="div-event-time">

                                <div>
                                    <span>Fecha:</span>
                                    <input type="text" id="edit-event-date" name="event-date" class="input-c">

                                    <span>Hora inicio:</span>
                                    <input type="text" id="edit-event-time-start" name="event-time-start" class="input-c">

                                    <span>Hora fin:</span>
                                    <input type="text" id="edit-event-time-end" name="event-time-end" class="input-c">
                                </div>

                                <div>
                                    <span>Invitados:</span>
                                    <select id="edit-event-guest" name="event-guest" class="input-c" size="5">
                                        <option value="Guest 1">Guest 1</option>
                                        <option value="Guest 2">Guest 2</option>
                                        <option value="Guest 3">Guest 3</option>
                                        <option value="Guest 4">Guest 4</option>
                                        <option value="Guest 5">Guest 5</option>
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