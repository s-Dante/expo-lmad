<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi QR | EXPO LMAD</title>

    {{-- Sidebar --}}
    @vite([
        'resources/css/components/sidebar.css',
        'resources/css/student/qr.css'
    ])

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
                    <span>Asistencia Registrada</span>
                </div>
            @else
                <div class="estatus pending">
                    <span>⏳ Pendiente de Registro</span>
                </div>
            @endif

            <div class="header">
                <h1>Pase de Acceso</h1>
                <p>EXPO LMAD {{ date('Y') }}</p>
            </div>

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