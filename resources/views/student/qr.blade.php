<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi QR - Expo LMAD</title>

    {{-- Sidebar --}}
    @vite(['resources/css/components/sidebar.css'])

    {{-- 
        Estilo simple para que se vea la info mas o menos bien, 
        Todo esto pueden personalizarlo mejor supongo 
    --}}
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background-color: #f3f3f3;
            color: #1f1f1f
            ;
        }

        main {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: margin-left 0.3s ease;
        }

        @media (min-width: 768px) {
            main {
                margin-left: 16rem;
            }
        }

        /* ---------- Card ---------- */
        .card {
            position: relative;
            background-color: #ffffff;
            padding: 2rem;
            max-width: 28rem;
            width: 100%;
            text-align: center;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        /* ---------- Estado ---------- */
        .estatus {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 0.5rem 0;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .estatus.success {
            background-color: #22c55e;
            color: #ffffff;
        }

        .estatus.pending {
            background-color: #e5e7eb;
            color: #6b7280;
        }

        /* ---------- Header ---------- */
        .header {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .header p {
            color: #6b7280;
            font-weight: 500;
        }

        /* ---------- QR ---------- */
        .qr-box {
            position: relative;
            display: inline-block;
            padding: 1rem;
            margin-bottom: 1.5rem;
            background-color: #ffffff;
            border-radius: 0.5rem;
            border: 2px solid #f3f4f6;
        }

        .qr-box img.qr {
            width: 16rem;
            height: 16rem;
            opacity: 0.9;
            mix-blend-mode: multiply;
        }

        /* Logo centrado */
        .qr-logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 0.25rem;
        }

        .qr-logo img {
            width: 5rem;
            height: 5rem;
            object-fit: contain;
        }

        /* ---------- Datos ---------- */
        .estudiante {
            margin-bottom: 1.5rem;
        }

        .estudiante h2,
        .estudiante h3 {
            font-size: 1.25rem;
            font-weight: 700;
            text-transform: uppercase;
            margin: 0;
        }

        .estudiante h3 {
            color: #374151;
        }

        .matricula {
            display: inline-block;
            margin-top: 0.5rem;
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            font-family: monospace;
            color: #1e40af;
            background-color: #eff6ff;
            border-radius: 999px;
            border: 1px solid #dbeafe;
        }

        /* ---------- Mensajes ---------- */
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            border: 1px solid;
        }

        .alert.success {
            background-color: #ecfdf5;
            color: #065f46;
            border-color: #a7f3d0;
        }

        .alert.info {
            background-color: #eff6ff;
            color: #1e40af;
            border-color: #dbeafe;
        }

        .alert p {
            margin: 0.25rem 0;
        }

        .alert .title {
            font-weight: 700;
            font-size: 1.125rem;
        }

        .alert .small {
            font-size: 0.75rem;
            margin-top: 0.5rem;
            opacity: 0.8;
        }
    </style>

</head>

<body>

    <x-sidebar />

    <main>

        {{-- Tarjeta del QR 
                Ojo, esta tarjeta podria ser un componente y tener mejor diseño
        --}}
        <article class="card">

            {{-- ESTADO DE LA ASISTENCIA --}}
            {{--
                    NOta: Pueden decidir si dejar o quitar los stickers jajajaj, o cambiarlos por 
                    texto simple o iconos personalizados XD 
                --}}
            @if($asistio)
            <div class="estatus success">✅ Asistencia Registrada</div>
            @else
            <div class="estatus pending">⏳ Pendiente de Registrar su Asistencia</div>
            @endif

            <header class="header">
                <h1>Pase de Acceso</h1>
                <p>EXPO LMAD {{ date('Y') }}</p>
            </header>

            {{-- Código QR --}}
            <figure class="qr-box">
                <img class="qr"
                    src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&ecc=H&data={{ $estudiante->matricula }}"
                    alt="QR Acceso">

                <div class="qr-logo">
                    <img src="{{ asset('assets/guest/logo expo_lmad.png') }}" alt="Logo">
                </div>
            </figure>

            {{-- Datos del Estudiante --}}
            <div class="estudiante">
                <h2>{{ $estudiante->nombre }}</h2>
                <h3>{{ $estudiante->apellido_paterno }} {{ $estudiante->apellido_materno }}</h3>
                <div class="matricula">{{ $estudiante->matricula }}</div>
            </div>

            {{-- Mensajes de asistencia --}}
            {{-- 
                Nota: Pueden personalizar los mensajes como quieran 
                Ademas podrian ver si quieren cambiar los colores con los que se muestra
            --}}
            @if($asistio)
            <div class="alert success">
                <p class="title">¡Bienvenido!</p>
                <p>Tu entrada ha sido validada correctamente.</p>
                <p class="small">Disfruta el evento.</p>
            </div>
            @else
            <div class="alert info">
                <p><strong>Instrucciones:</strong></p>
                <p>Presenta este código al Staff para registrar tu asistencia.</p>
            </div>
            @endif

        </article>
    </main>
</body>


</html>



{{--
Si quieren hacer pruebas y saber que "estudiantes" tienen o no asistencia registrada, 
pueden usar estas consultas SQL:

-- Los que NO tienen asistencia registrada:
SELECT e.*
FROM tbl_estudiantes e
LEFT JOIN tbl_asistencias_general a
    ON a.estudiante_id = e.id
WHERE e.usuario_id IS NOT NULL
  AND a.estudiante_id IS NULL;


-- Los que SI tienen asistencia registrada:
SELECT DISTINCT e.*
FROM tbl_estudiantes e
INNER JOIN tbl_asistencias_general a
    ON a.estudiante_id = e.id
WHERE e.usuario_id IS NOT NULL;
--}}