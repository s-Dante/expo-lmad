<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Estudiante | EXPO LMAD</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/student/dashboard.css'
    ])

</head>

<body>

    <x-sidebar />

    <main>
        {{--
            De nuevo el diseño en esta pagina es meramente demostrativo, y puede ser mejorado
        --}}

        {{-- Header --}}
        <header class="header">
            <div>
                <h1 class="title">Panel de Control</h1>
                <p class="subtitle">Bienvenid@ a la plataforma Expo LMAD</p>
            </div>

            {{-- Esta seccion obtiene la informacion del usuario para mostrarla --}}
            <div class="user-info">
                <div class="user-name">
                    {{ auth()->user()->nombre }}
                    {{ auth()->user()->apellido_paterno }}
                    {{ auth()->user()->apellido_materno }}
                </div>

                <div class="user-meta">
                    <span>Estudiante</span>
                    <span>|</span>
                    <span>{{ auth()->user()->estudiante->matricula ?? 'S/M' }}</span>
                </div>
            </div>
        </header>

        <center>
            <input type="text" disabled class="hr-gradient">
        </center>
        {{-- 
            Tarjetas de informacion 
                Estas podrian componetizarse, queda a consideracion el hacerlo o no
        --}}
        <section class="cards">

            {{-- Tarjeta de Proyectos Asignados --}}
            <div class="card blue">
                <p class="card-label">Proyectos Asignados</p>
                <div class="card-content">
                    <p class="card-number">{{ $conteoProyectos ?? 0 }}</p>
                    <div class="icon blue">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Tarjeta de Proyectos Pendientes/Revisión --}}
            <div class="card yellow">
                <p class="card-label">En Revisión / Pendiente</p>
                <div class="card-content">
                    <p class="card-number">{{ $conteoPendientes ?? 0 }}</p>
                    <div class="icon yellow">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Tarjeta de Proyectos Aprobados --}}
            <div class="card green">
                <p class="card-label">Proyectos Aprobados</p>
                <div class="card-content">
                    <p class="card-number">{{ $conteoAprobados ?? 0 }}</p>
                    <div class="icon green">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

        </section>

        {{-- 
            Caja de informacion relevante 
                De nuevo la informacion mostrada puede ser modificada segun lo que se quiera resaltar
                Lo que coloque aqui es meramente demostrativo
        --}}
        <section class="info">
            <div class="info-header">
                ℹ
                <h3>Información Relevante</h3>
            </div>

            <ul>
                <li><span>•</span> Tu Código QR es necesario para registrar asistencia.</li>
                <li><span>•</span> Si tu proyecto es rechazado, deberás corregir observaciones.</li>
                <li><span>•</span> El póster debe estar en formato 1:1.</li>
            </ul>
        </section>

    </main>

</body>

</html>