<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro - EXPO LMAD</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/guest/registro.css',
        'resources/css/components/sidebar.css',
        'resources/js/guest/afi/actions-registro.js',
    ])
</head>

<body>

    {{-- Navbar --}}
    <header class="hero">
        <div class="bg-navbar d-none"></div>
        <img src="{{ asset('assets/guest/expolmadimg.png') }}" alt="EXPO LMAD" class="hero-banner" />
        <x-guest.header-title>Registro de AFI</x-guest.header-title>
        <x-guest.navbar />
    </header>

    <section>

        <form id="form-registro">

            <container class="card-expo">

                <h1>Registro de asistencia</h1>
                <p style="text-align:center; margin-bottom:1.5rem; color:var(--gray); font-weight:400; font-size:0.9rem;">
                    Llena tus datos para registrarte en la conferencia o taller al que asistirás.
                </p>

                {{-- Mensaje de respuesta (éxito / error) --}}
                <div id="msg-registro" class="form-msg" style="display:none;"></div>

                <div class="grid">

                    {{-- Columna izquierda --}}
                    <div>
                        <p>Facultad</p>
                        <select id="select-facultad" name="facultad" required>
                            <option value="" disabled selected>Selecciona una facultad</option>
                            {{-- Opciones cargadas dinámicamente desde /data/facultades.json --}}
                        </select>

                        <div id="container-carrera">
                            <p>Carrera</p>
                            <select id="select-carrera" name="carrera" disabled>
                                <option value="" disabled selected>Selecciona una carrera</option>
                            </select>
                        </div>

                        <div id="container-dependencia" class="d-none">
                            <p>Dependencia / Institución</p>
                            <input type="text" id="input-dependencia" name="dependencia" placeholder="Escribe tu dependencia o institución">
                        </div>

                        <p>Conferencia / Taller (AFI)</p>
                        <select id="conferencias" name="conferencias" required>
                            <option value="" disabled selected>Cargando eventos...</option>
                        </select>
                    </div>

                    {{-- Columna derecha --}}
                    <div>
                        <p>Nombre completo</p>
                        <input type="text" id="input-nombre" name="nombre" placeholder="Nombre(s) Apellido Paterno Apellido Materno" required>

                        <p>Matrícula</p>
                        <input type="text" id="input-matricula" name="matricula" placeholder="Ej. 1985623" required>

                        <p>Correo universitario <span style="font-size:0.78rem; color:var(--gray); font-weight:400;">(Opcional)</span></p>
                        <div>
                            <input type="text" id="input-correo" name="correo" placeholder="algo.ejemplo">
                            <span>@uanl.edu.mx</span>
                        </div>
                        <p style="font-size:0.78rem; color:var(--gray); font-weight:400; margin-top:0.4rem; margin-bottom:0;">
                            Si lo proporcionas, recibirás un token de confirmación por correo. De lo contrario, el token se mostrará en pantalla al registrarte.
                        </p>
                    </div>

                </div>

                <button type="submit" class="btn btn-purple" id="btn-registrar">Registrar</button>

            </container>

        </form>

    </section>

    <article class="card-info">
        <span>EXPO LMAD - Mayo - 2026</span>
        <img src="{{ asset('assets/guest/icon-arrow-down.png') }}" alt="" />
    </article>

</body>

</html>