<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EXPO LMAD - Staff</title>
    @vite([
    "resources/css/staff/empresas.css"
    ])
</head>

<body>
    <x-sidebar />
    <main class="main-content">
        <header>
            <h1 class="text-main">EMPRESAS</h1>
            <span class="line"></span>
        </header>

        <section class="section-container">

            {{-- Nombre de la empresa --}}
            <h2 class="empresa-nombre-titulo">{{ $empresa->nombre }}</h2>
            <p class="empresa-subtitulo">Registra a los representantes que asistieron al evento.</p>

            {{-- Mensajes de sesión --}}
            @if(session('exito'))
                <div class="msg-empresa msg-exito">{{ session('exito') }}</div>
            @endif
            @if(session('error'))
                <div class="msg-empresa msg-error">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="msg-empresa msg-error">{{ $errors->first() }}</div>
            @endif

            {{-- Formulario dinámico --}}
            <form id="form-representantes"
                  action="{{ route('staff.empresa-representantes', $empresa->id) }}"
                  method="POST">
                @csrf

                <div id="lista-representantes">
                    {{-- Los campos se insertan dinámicamente con JS --}}
                </div>

                <div class="acciones-form">
                    <button type="button" id="btn-agregar" class="btn-accion btn-agregar">
                        + Agregar otro
                    </button>
                    <button type="submit" class="btn-accion">
                        Enviar asistencia
                    </button>
                </div>

            </form>

        </section>

        {{-- Enlace de regreso --}}
        <div class="volver-empresas">
            <a href="{{ route('staff.empresas') }}" class="btn-accion" style="text-decoration:none; font-size:0.85rem;">
                ← Volver a empresas
            </a>
        </div>

    </main>

    <script>
        const lista = document.getElementById('lista-representantes');
        const btnAgregar = document.getElementById('btn-agregar');
        let contador = 0;

        function crearCampo() {
            const esElPrimero = contador === 0;
            const idx = contador++;

            const div = document.createElement('div');
            div.classList.add('campo-representante');

            div.innerHTML = `
                <div class="input-inline" style="flex:1;">
                    <label>Nombre completo</label>
                    <input type="text"
                           name="nombres[]"
                           placeholder="Nombre(s) Apellido Paterno Apellido Materno"
                           required
                           autocomplete="off">
                </div>
                ${!esElPrimero
                    ? `<button type="button" class="btn-quitar" title="Quitar" onclick="this.parentElement.remove()">✕</button>`
                    : `<div class="btn-quitar-placeholder"></div>`
                }
            `;

            lista.appendChild(div);
        }

        // Inicia con un campo vacío
        crearCampo();

        btnAgregar.addEventListener('click', crearCampo);
    </script>

</body>
</html>
