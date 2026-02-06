<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Estudiante | EXPO LMAD</title>

    <style>
        main {
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }

        @media (min-width: 768px) {
            main {
                margin-left: 16rem;
            }
        }

        .header {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid #e5e7eb;
        }

        @media (min-width: 768px) {
            .header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .title {
            font-size: 1.9rem;
            font-weight: 800;
            color: #111827;
        }

        .subtitle {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .user-meta {
            display: flex;
            justify-content: flex-end;
            gap: 0.4rem;
            margin-top: 0.3rem;
            font-size: 0.65rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #9ca3af;
        }

        .user-meta code {
            font-family: monospace;
            color: #6b7280;
        }

        .cards {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        @media (min-width: 768px) {
            .cards {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 1rem;
            padding: 1.5rem;
            height: 8rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: border-color 0.3s ease;
        }

        .card-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #9ca3af;
        }

        .card-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .card-number {
            font-size: 2.5rem;
            font-weight: 800;
        }

        .icon {
            padding: 0.5rem;
            border-radius: 0.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .yellow {
            background: #fef9c3;
            color: #ca8a04;
        }

        .green {
            background: #ecfdf5;
            color: #16a34a;
        }

        .icon svg {
            width: 24px;
            height: 24px;
        }

        /* ====== Info box ====== */
        .info {
            background: rgba(219, 234, 254, 0.5);
            border: 1px solid #bfdbfe;
            border-radius: 1rem;
            padding: 1.5rem;
        }

        .info-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .info-header h3 {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #1e40af;
        }

        .info ul {
            list-style: none;
            font-size: 0.85rem;
            color: #4b5563;
        }

        .info li {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }
    </style>
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
                    <code>{{ auth()->user()->estudiante->matricula ?? 'S/M' }}</code>
                </div>
            </div>
        </header>

        {{-- 
            Tarjetas de informacion 
                Estas podrian componetizarse, queda a consideracion el hacerlo o no
        --}}
        <section class="cards">

            {{-- Tarjeta de Proyectos Asignados --}}
            <div class="card">
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
                <li><span>•</span> Tu <strong>Código QR</strong> es necesario para registrar asistencia.</li>
                <li><span>•</span> Si tu proyecto es rechazado, deberás corregir observaciones.</li>
                <li><span>•</span> El póster debe estar en formato 1:1.</li>
            </ul>
        </section>

    </main>

</body>

</html>