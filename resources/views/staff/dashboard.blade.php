<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - EXPO LMAD</title>
    @vite([
        'resources/css/guest/template.css',
        'resources/css/admin/dashboard.css'
    ])
    <style>
        .staff-nav-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
            padding: 0 2rem;
        }
        .staff-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2.5rem 2rem;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: var(--text-primary);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .staff-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            border-color: var(--contrast-color-A);
            background: linear-gradient(145deg, var(--bg-secondary) 0%, rgba(138, 43, 226, 0.08) 100%);
        }
        .staff-card h2 {
            margin-top: 1rem;
            font-size: 1.5rem;
            color: var(--contrast-color-A);
            font-weight: 600;
        }
        .staff-card p {
            margin-top: 0.8rem;
            color: var(--clr-gray);
            font-size: 0.95rem;
            line-height: 1.5;
        }
        .staff-icon {
            font-size: 3.5rem;
            margin-bottom: 0.5rem;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
        }
    </style>
</head>
<body>
    <x-sidebar />

    <main>
        <header class="header" style="padding: 2rem; border-bottom: 1px solid var(--border-color);">
            <div>
                <h1 class="title">Dashboard Staff</h1>
                <p style="color: var(--clr-gray); margin-top: 0.5rem;">Panel de acceso rápido para herramientas de Staff</p>
            </div>

            <div class="user-info">
                <div class="user-name">
                    {{ auth()->user()->nombre ?? '' }} {{ auth()->user()->apellido_paterno ?? '' }}
                </div>
                <div class="user-meta">
                    <span>Staff</span>
                    <span>|</span>
                    <span>{{ auth()->user()->email ?? '' }}</span>
                </div>
            </div>
        </header>

        <section class="staff-nav-grid">
            <a href="{{ route('staff.visitantes') }}" class="staff-card">
                <div class="staff-icon">👥</div>
                <h2>Visitantes</h2>
                <p>Registro de asistencia de público general, alumnos e invitados</p>
            </a>

            <a href="{{ route('staff.expositor') }}" class="staff-card">
                <div class="staff-icon">🎤</div>
                <h2>Expositores</h2>
                <p>Gestión y registro de estudiantes expositores de proyectos</p>
            </a>

            <a href="{{ route('staff.empresas') }}" class="staff-card">
                <div class="staff-icon">🏢</div>
                <h2>Empresas</h2>
                <p>Módulo para escaneo de códigos de empresas y patrocinadores</p>
            </a>

            <a href="{{ route('staff.eventos') }}" class="staff-card">
                <div class="staff-icon">📅</div>
                <h2>Eventos</h2>
                <p>Control de acceso para conferencias, talleres y ponencias (AFI)</p>
            </a>
        </section>
    </main>
</body>
</html>