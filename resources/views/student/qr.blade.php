<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi QR | EXPO LMAD</title>

    {{-- Sidebar --}}
    @vite(['resources/css/components/sidebar.css'])

    <style>
        main {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: margin-left 0.3s ease;
        }

        @media (min-width: 768px) {
            main {
                margin-left: 10em;
            }
        }

        .card {
            position: relative;
            background-color: #ffffff;
            padding: 2.5rem 2rem;
            max-width: 26rem;
            width: 100%;
            text-align: center;
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .estatus {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 0.6rem 0;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .estatus.success {
            background-color: #10b981;
            color: #ffffff;
        }

        .estatus.pending {
            background-color: #f3f4f6;
            color: #6b7280;
        }

        .header h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #111827;
            margin: 0;
        }

        .header p {
            color: #9ca3af;
            font-weight: 600;
            font-size: 0.875rem;
            margin-top: 0.22rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .qr-container {
            position: relative;
            display: inline-block;
            padding: 1rem;
            background: white;
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
        }

        .qr-logo-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100px;
            height: 100px;
        }

        .qr-logo-overlay img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .estudiante {
            margin-bottom: 0.5rem;
        }

        .estudiante h2 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #111827;
            margin: 0;
        }

        .estudiante h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #4b5563;
            margin: 0;
        }

        .matricula {
            display: inline-block;
            margin-top: 0.75rem;
            padding: 0.35rem 1rem;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            color: #2563eb;
            background-color: #eff6ff;
            border-radius: 9999px;
            border: 1px solid #bfdbfe;
        }

        .alert {
            padding: 1.25rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            border: 1px solid;
            text-align: center;
        }

        .alert.success {
            background-color: #ecfdf5;
            color: #065f46;
            border-color: #6ee7b7;
        }

        .alert.info {
            background-color: #f8fafc;
            color: #334155;
            border-color: #e2e8f0;
        }

        .alert p {
            margin: 0;
        }

        .alert .title {
            font-weight: 800;
            font-size: 1rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .alert .small {
            font-size: 0.75rem;
            margin-top: 0.5rem;
            opacity: 0.8;
            font-style: italic;
        }
    </style>

</head>

<body>

    <x-sidebar />

    <main>

        {{--
            De nuevo, este podria ser un componente aparte en donde se muestre la informacion que ya se muestra aqui
        --}}

        <article class="card">

            {{--
                Esta parte muestra si tiene o no asistencia
            --}}
            @if($asistio)
            <div class="estatus success">
                <span>✅ Asistencia Registrada</span>
            </div>
            @else
            <div class="estatus pending">
                <span>⏳ Pendiente de Registro</span>
            </div>
            @endif

            <header class="header">
                <h1>Pase de Acceso</h1>
                <p>EXPO LMAD {{ date('Y') }}</p>
            </header>

            {{-- Código QR Generado desde Backend --}}
            <figure class="qr-container">
                {!! $qrCode !!}

                {{--
                    Logo superpuesto
                        Deberiamos de buscar el logo actual de la expo y ponerlo aqui 
                            (Podriamos quiza incluso esta variabla hacerla variable 
                            de entorno para que se camvie mas facilmente)
                --}}
                <div class="qr-logo-overlay">
                    <img src="{{ asset('assets/guest/logo expo_lmad.png') }}" alt="Logo">
                </div>
            </figure>

            {{--
                Aqui se muestra la informacion del estudiante
            --}}
            <div class="estudiante">
                <h2>{{ $estudiante->nombre }}</h2>
                <h3>{{ $estudiante->apellido_paterno }} {{ $estudiante->apellido_materno }}</h3>
                <div class="matricula">{{ $estudiante->matricula }}</div>
            </div>

            {{--
                Aqui le damos un contexto en caso de si tiene o no asistencia, este texto puede cambiar
            --}}
            @if($asistio)
            <div class="alert success">
                <span class="title">¡Bienvenid@ al evento!</span>
                <p>Tu asistencia ha sido validada correctamente en el sistema.</p>
                <p class="small">Disfruta de las conferencias y proyectos.</p>
            </div>
            @else
            <div class="alert info">
                <span class="title">Instrucciones de Acceso:</span>
                <p>Por favor, presenta este código al Staff para validar tu asistencia.</p>
            </div>
            @endif

        </article>
    </main>

    @vite(['resources/js/components/sidebar.js'])
</body>

</html>