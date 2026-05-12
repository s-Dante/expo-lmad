<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Confirmar Asistencia - EXPO LMAD</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/guest/registro.css',
        'resources/css/components/sidebar.css',
        'resources/js/guest/actions-asistencia.js'
    ])
</head>

<body>

    <header class="hero">
        <div class="bg-navbar d-none"></div>
        <img src="{{ asset('assets/guest/expolmadimg.png') }}" alt="EXPO LMAD" class="hero-banner" />
        <x-guest.header-title>Asistencia de AFI</x-guest.header-title>
        <x-guest.navbar />
    </header>

    <section class="section-form-card">
        <container class="card-expo">

            <h1>Confirmar asistencia</h1>
            <p style="text-align:center; margin-bottom:1.5rem; color:var(--gray); font-weight:400; font-size:0.9rem;">
                El evento está por terminar. Confirma que estuviste presente.
            </p>

            {{-- Tabs para elegir método de confirmación --}}
            <div class="tabs-asistencia">
                <button class="tab-btn active" data-tab="opcion2">
                    Opción 1 — Por token de correo
                </button>
                <button class="tab-btn" data-tab="opcion1">
                    Opción 2 — Por matrícula
                </button>
            </div>

            {{-- ── OPCIÓN 2: confirmación por token de correo ──────────── --}}
            <div class="tab-panel active" id="panel-opcion2">

                <p style="font-size:0.85rem; color:var(--gray); font-weight:400; margin-bottom:1.2rem;">
                    Al registrarte recibiste un correo con un token de 8 caracteres. Ingrésalo aquí junto con tu correo
                    para confirmar tu asistencia.
                </p>

                <div id="msg-opcion2" class="form-msg" style="display:none;"></div>

                <form id="form-opcion2">
                    <div>
                        <p>Correo universitario</p>
                        <div style="display:flex; align-items:center; gap:0.8rem;">
                            <input type="text" id="input-correo-op2" name="correo" placeholder="jane.doe"
                                style="flex:1;">
                            <span style="color:var(--gray); font-weight:700; white-space:nowrap;">@uanl.edu.mx</span>
                        </div>
                    </div>

                    <div>
                        <p>Token de confirmación</p>
                        <input type="text" id="input-token-op2" name="token" placeholder="Ej. A3X9KP2Q" maxlength="8"
                            style="letter-spacing:0.3em; text-transform:uppercase;">
                        <p style="font-size:0.78rem; color:var(--gray); font-weight:400; margin-top:0.3rem;">
                            Revisa el correo que recibiste al inicio del evento.
                        </p>
                    </div>

                    <button type="submit" class="btn btn-purple" id="btn-confirmar-op2">
                        Confirmar con token
                    </button>
                </form>

            </div>

            {{-- ── OPCIÓN 1: confirmación por matrícula ────────────────── --}}
            <div class="tab-panel" id="panel-opcion1">

                <p style="font-size:0.85rem; color:var(--gray); font-weight:400; margin-bottom:1.2rem;">
                    Ingresa tu matrícula y el evento al que asististe. El sistema buscará tu registro de entrada y
                    confirmará tu asistencia.
                </p>

                <div id="msg-opcion1" class="form-msg" style="display:none;"></div>

                <form id="form-opcion1">

                    <div>
                        <p>Evento</p>
                        <select id="select-evento-op1" name="evento_id">
                            <option value="" disabled selected>Cargando eventos...</option>
                        </select>
                    </div>

                    <div>
                        <p>Matrícula</p>
                        <input type="text" id="input-matricula-op1" name="matricula" placeholder="Ej. 1985623">
                    </div>

                    <div>
                        <button type="submit" class="btn btn-purple" id="btn-confirmar-op1">
                            Confirmar asistencia
                        </button>
                    </div>

                </form>

            </div>

        </container>
    </section>

    <article class="card-info">
        <span>EXPO LMAD - Mayo - 2026</span>
        <img src="{{ asset('assets/guest/icon-arrow-down.png') }}" alt="" />
    </article>

</body>

</html>