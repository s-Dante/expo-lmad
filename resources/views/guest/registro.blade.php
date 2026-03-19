<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro AFI - EXPO LMAD</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/guest/registro.css',
        'resources/css/components/sidebar.css',
        'resources/js/guest/afi/actions-registro.js',
        'resources/js/guest/afi/register-afi.js'
    ])
</head>

<body>

    <header class="hero">
        <div class="bg-navbar d-none"></div>
        <img src="{{ asset('assets/guest/expolmadimg.png') }}" alt="EXPO LMAD" class="hero-banner" />
        <x-guest.header-title>Registro de AFI</x-guest.header-title>
        <x-guest.navbar />
    </header>

    <section class="section-main">

        <form id="form-register">

            <container class="card-expo">

                <div class="grid">

                    <div>
                        <p>Facultad</p>
                        <select id="select-facultad" name="facultad">
                            <option value="" disabled selected>Selecciona una facultad</option>
                            <option value="FCFM">Facultad de Ciencias Físico Matemáticas</option>
                            <option value="NP">Otro(s)</option>
                            <option value="FA">Facultad de Agronomía</option>
                            <option value="FARQ">Facultad de Arquitectura</option>
                            <option value="FAV">Facultad de Artes Visuales</option>
                            <option value="FCB">Facultad de Ciencias Biológicas</option>
                            <option value="FC">Facultad de Ciencias de la Comunicación</option>
                            <option value="FCT">Facultad de Ciencias de la Tierra</option>
                            <option value="FCF">Facultad de Ciencias Forestales</option>
                            <option value="FCPRI">Facultad de Ciencias Políticas y Relaciones Internacionales</option>
                            <option value="FCQ">Facultad de Ciencias Químicas</option>
                            <option value="FCPA">Facultad de Contaduría Pública y Administrativa</option>
                            <option value="FDC">Facultad de Derecho y Criminología</option>
                            <option value="FE">Facultad de Economía</option>
                            <option value="FAEN">Facultad de Enfermería</option>
                            <option value="FFL">Facultad de Filosofía y Letras</option>
                            <option value="FIC">Facultad de Ingeniería Civil</option>
                            <option value="FIME">Facultad de Ingeniería Mecánica y Eléctrica</option>
                            <option value="FACMED">Facultad de Medicina</option>
                            <option value="FACVE">Facultad de Medicina Veterinaria y Zootecnia</option>
                            <option value="FMU">Facultad de Música</option>
                            <option value="FO">Facultad de Odontología</option>
                            <option value="FOD">Facultad de Organización Deportiva</option>
                            <option value="FP">Facultad de Psicología</option>
                            <option value="FSPN">Facultad de Salud Pública y Nutrición</option>
                            <option value="FTSDH">Facultad de Social y Desarrollo Humano</option>
                        </select>

                        <div id="container-carrera">
                            <p>Carrera</p>
                            <select id="select-carrera" name="carrera" disabled>
                                <option value="" disabled selected>Selecciona una carrera</option>
                                <option value="LMAD">Licenciatura en Multimedia y Animación Digital</option>
                                <option value="LA">Licenciatura en Actuaría</option>
                                <option value="LCC">Licenciatura en Ciencias Computacionales</option>
                                <option value="LF">Licenciatura en Física</option>
                                <option value="LM">Licenciatura en Matemáticas</option>
                                <option value="LSTI">Licenciatura en Seguridad de Tecnologías de Información</option>
                            </select>
                        </div>

                        <div id="container-dependencia" class="d-none">
                            <p>Dependencia</p>
                            <input type="text" id="input-dependencia" name="dependencia">
                        </div>

                        <p>AFI</p>
                        <select id="conferencias" name="conferencias">
                            <option value="" disabled selected>Selecciona una conferencia</option>
                            <option value="dummy">Opcion dummy para test</option>
                        </select>
                    </div>

                    <div>
                        <p>Nombre completo</p>
                        <input type="text" id="nombre" name="nombre">

                        <p>Matrícula</p>
                        <input type="text" id="matricula" name="matricula">

                        <p>Correo universitario</p>
                        <div>
                            <input type="text" id="email" name="email">
                            <span>@uanl.edu.mx</span>
                        </div>

                    </div>

                </div>

                <button class="btn btn-purple" id="btn-registrar"> Registrar </button>

            </container>

        </form>

    </section>


    <article class="card-info">
        <span>EXPO LMAD - Mayo - 2026</span>
        <img src="{{ asset('assets/guest/icon-arrow-down.png') }}" alt="" />
    </article>

</body>

</html>