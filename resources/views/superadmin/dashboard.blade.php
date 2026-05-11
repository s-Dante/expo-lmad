<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperAdmin Dashboard</title>
    @vite([
        "resources/css/superadmin/dashboard.css"
    ])
</head>

<body>
    <x-sidebar />
    <div class="main-content">

        <header>
            <h1 class="text-main">DATA</h1>
            <span class="line"></span>
        </header>

        <section class="general-section">
            <h2 class="section-title">Asistencia general</h2>

            <div class="stats-container">

                <div class="stat-card main-circle">
                    <div class="circle-content">
                        <span class="number">{{ $totalAsistentes }}</span>
                        <span class="label">TOTAL DE ASISTIDOS</span>
                    </div>
                </div>

                <div class="stat-card tall-card">
                    <span class="number">{{ $alumnos }}</span>
                    <span class="label">ALUMNOS</span>
                </div>

                <div class="stat-card combined-card">
                    <div class="top-val">
                        <span class="number">{{ $externos['total'] }}</span>
                        <span class="label">EXTERNOS</span>
                    </div>

                    <div class="bottom-vals">
                        <div><span class="sub-num">{{ $externos['femenino'] }}</span><span
                                class="sub-label">FEMENINO</span></div>
                        <div><span class="sub-num">{{ $externos['masculino'] }}</span><span
                                class="sub-label">MASCULINO</span></div>
                    </div>

                    <div class="no-binario-val">
                        <span class="sub-num">{{ $externos['otro'] > 0 ? $externos['otro'] : '—' }}</span>
                        <span class="sub-label">NO BINARIO</span>
                    </div>
                </div>

                <div class="stat-card mini-cards-col">
                    <div class="mini-card">
                        <img src="{{ asset('assets/superadmin/calendario-1.png') }}" alt="Eventos" class="mini-icon">
                        <div class="mini-data">
                            <span class="mini-number">{{ $totalEventos }}</span>
                            <span class="mini-label">EVENTOS</span>
                        </div>
                    </div>

                    <div class="mini-card">
                        <img src="{{ asset('assets/superadmin/empresa-1.png') }}" alt="Empresas" class="mini-icon">
                        <div class="mini-data">
                            <span class="mini-number">{{ $totalEmpresas }}</span>
                            <span class="mini-label">EMPRESAS</span>
                        </div>
                    </div>
                </div>

        </section>

        <span class="line2"></span>

        <section class="events-section">
            <h2 class="section-title">Asistencia a eventos</h2>

            <div class="events-grid">

                @forelse ($asistenciaEventos as $evento)
                    @php
                        $maxAsistentes = $asistenciaEventos->max('asistentes') ?: 1;
                        $porcentaje = round(($evento['asistentes'] / $maxAsistentes) * 100);
                    @endphp

                    <div class="event-name">{{ strtoupper($evento['titulo']) }}</div>
                    <div class="progress-wrapper">
                        <div class="progress-bar" style="width: {{ $porcentaje }}%;"></div>
                    </div>
                    <div class="event-number">{{ $evento['asistentes'] }}</div>
                @empty
                    <div class="event-name" style="grid-column: 1 / -1; color: var(--clr-gray); text-align: center;">
                        No hay eventos con asistencia registrada.
                    </div>
                @endforelse

            </div>

            <a href="{{ route('superadmin.dashboard.export') }}" class="btn-lg btn-purple">Exportar a excel</a>

        </section>

    </div>

</body>

</html>