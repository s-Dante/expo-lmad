<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/admin/dashboard.css',
    ])

</head>

<body>

    <x-sidebar />

    <main>

        <header class="header">
            <div>
                <h1 class="title">Dashboard</h1>
            </div>

            <div class="user-info">
                <div class="user-name">
                    {{ auth()->user()->nombre ?? '' }}
                    {{ auth()->user()->apellido_paterno ?? '' }}
                    {{ auth()->user()->apellido_materno ?? '' }}
                </div>

                <div class="user-meta">
                    <span>{{ ucfirst(auth()->user()->rol ?? 'Admin') }}</span>
                    <span>|</span>
                    <span>{{ auth()->user()->name ?? '' }}</span>
                </div>
            </div>
        </header>

        <center>
            <input type="text" disabled class="hr-gradient">
        </center>

        <section class="section-export">
            <a href="{{ route('admin.dashboard.export') }}" class="btn btn-purple">Exportar en Excel</a>
        </section>

        <section class="cards">

            <div class="card blue">
                <p class="card-label">Total de asistidos</p>
                <div class="card-content">
                    <p class="card-number">{{ number_format($totalAsistentes) }}</p>
                </div>
            </div>

            <div class="card yellow">
                <p class="card-label">Alumnos</p>
                <div class="card-content">
                    <p class="card-number">{{ number_format($alumnos) }}</p>
                </div>
            </div>

            <div class="card green">

                <div class="sub-card">

                    <div>
                        <p class="card-label">Externos</p>

                        <div class="card-content margin-mid">
                            <p class="card-number">{{ number_format($externos['total']) }}</p>
                        </div>
                    </div>

                    <div class="sub-group">
                        <div class="card-s green-s">
                            <p class="card-label">Masculino</p>
                            <div class="card-content">
                                <span class="card-number">{{ number_format($externos['masculino']) }}</span>
                            </div>
                        </div>

                        <div class="card-s green-s">
                            <p class="card-label">Femenino</p>
                            <div class="card-content">
                                <span class="card-number">{{ number_format($externos['femenino']) }}</span>
                            </div>
                        </div>

                        <div class="card-s green-s">
                            <p class="card-label">No binario</p>
                            <div class="card-content">
                                <span class="card-number">{{ number_format($externos['otro']) }}</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section>

        <section class="section-data-event">
            <div class="info blue">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </div>
                <div class="info-header">
                    <h2>{{ $totalEventos }}</h2>
                    <h3>Eventos</h3>
                </div>
            </div>

            <div class="info">
                <div class="icon blue">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <div class="info-header">
                    <h2>{{ $totalConferencistas }}</h2>
                    <h3>Expositores</h3>
                </div>
            </div>

            <div class="info">
                <div class="icon blue">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                    </svg>
                </div>
                <div class="info-header">
                    <h2>{{ $totalEmpresas }}</h2>
                    <h3>Empresas</h3>
                </div>
            </div>
        </section>

        <section class="section-other-data">
            <table class="table-data-conferences" style="width: 100%; text-align: center;">
                <tbody>
                    @forelse ($asistenciaEventos as $evento)
                        <tr>
                            <td class="td-data-conference">{{ $evento['titulo'] }}</td>
                            <td class="td-data">{{ $evento['asistentes'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="color: var(--clr-gray); padding: 1rem;">
                                No hay eventos registrados aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

    </main>

</body>

</html>