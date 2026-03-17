<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Empresas</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/admin/empresas-lista.css',
        'resources/js/components/load-portrait.js',
        'resources/js/admin/actions-empresas.js',
        'resources/js/admin/carrusel.js'

    ]);

</head>

<body>

    <x-sidebar />

    <main>
        <h1>Empresas</h1>

        <section class="section-companies-create">
            <form>
                <container class="expo-card container-companies-create">
                    <div class="div-companies-create">

                        <div class="d-grid-gap company-data">
                            <span>Nombre de la empresa:</span>
                            <input type="text" id="company-name" name="company-name" class="input-c">

                            <div class="checkbox-card">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" id="patrocinador" name="patrocinador" value="1"
                                        class="checkbox-input" {{ old('patrocinador') ? 'checked' : '' }}>
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
                                            <select type="listbox" id="company-name" name="company-name"
                                                class="input-c">
                                                <option value="" disabled selected>Selecciona un grado</option>
                                                <option>Titanium</option>
                                                <option>Diamante</option>
                                                <option>Oro</option>
                                                <option>Plata</option>
                                                <option>Bronce</option>
                                            </select>
                                        </div>

                                        <div class="d-grid-gap">
                                            <span>Link:</span>
                                            <input type="text" id="company-link" name="company-link" class="input-c">
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
                            <x-admin.company-card name="OXXO" />
                            <x-admin.company-card image="{{asset('assets/guest/sponsor(1).svg')}}" name="Epic Games"
                                tier="Titanium" />
                            <x-admin.company-card image="{{asset('assets/guest/sponsor(2).svg')}}" name="Coca Cola"
                                tier="Gold" />
                            <x-admin.company-card image="{{asset('assets/guest/sponsor(3).svg')}}" name="Accenture"
                                tier="Bronze" />
                        </div>

                    </div>

                </div>

                <button class="carousel-btn btn-next" aria-label="Siguiente">&#10095;</button>
            </div>
        </section>

    </main>

</body>

</html>