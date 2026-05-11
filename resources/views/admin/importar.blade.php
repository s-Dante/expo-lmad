<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Importar Datos - Admin EXPO LMAD</title>

    @vite([
        'resources/css/guest/template.css',
    ])

    <style>
        /* ── Layout general ─────────────────────────────────────── */
        main {
            margin-left: 260px;
            padding: 2rem 2.5rem;
            color: var(--white, #fff);
            min-height: 100vh;
        }
        main h1 {
            font-size: 2rem;
            margin-bottom: 0.4rem;
        }
        .subtitle {
            color: var(--gray, #8899aa);
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        /* ── Orden de importación ──────────────────────────────── */
        .orden-banner {
            background: rgba(200, 217, 61, 0.08);
            border: 1px solid rgba(200, 217, 61, 0.3);
            border-radius: 12px;
            padding: 1rem 1.4rem;
            margin-bottom: 2rem;
            font-size: 0.88rem;
            color: #c8d93d;
        }
        .orden-banner strong { display: block; margin-bottom: 0.4rem; font-size: 0.95rem; }
        .orden-banner ol { margin: 0; padding-left: 1.4rem; color: rgba(200, 217, 61, 0.8); }
        .orden-banner li { margin: 0.2rem 0; }

        /* ── Tarjeta de importación ────────────────────────────── */
        .import-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 1.5rem;
        }
        .import-card {
            background: var(--blue-950, #050e20);
            border: 1px solid var(--blue-600, #1e3a5f);
            border-radius: 16px;
            padding: 1.6rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .import-card h2 {
            font-size: 1.1rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .import-card .badge {
            font-size: 0.7rem;
            padding: 0.15rem 0.5rem;
            border-radius: 20px;
            background: rgba(100, 160, 255, 0.15);
            color: #7eceff;
            border: 1px solid rgba(100, 160, 255, 0.3);
        }
        .import-card .badge.dep {
            background: rgba(255, 200, 50, 0.12);
            color: #ffd966;
            border-color: rgba(255, 200, 50, 0.25);
        }
        .import-card p.desc {
            font-size: 0.82rem;
            color: var(--gray, #8899aa);
            margin: 0;
            line-height: 1.5;
        }

        /* Columnas de la tabla de formato */
        .format-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.78rem;
            margin-top: 0.3rem;
        }
        .format-table th {
            background: rgba(255,255,255,0.05);
            color: #7eceff;
            padding: 0.35rem 0.6rem;
            text-align: left;
            font-weight: 600;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .format-table td {
            padding: 0.3rem 0.6rem;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            color: rgba(255,255,255,0.7);
        }
        .format-table td.req { color: #ff9090; }
        .format-table td.opt { color: #8899aa; }

        /* File input + botón */
        .upload-row {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            flex-wrap: wrap;
        }
        .upload-row input[type="file"] {
            flex: 1;
            min-width: 0;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--blue-600, #1e3a5f);
            border-radius: 8px;
            padding: 0.5rem 0.7rem;
            color: var(--white, #fff);
            font-size: 0.85rem;
        }
        .upload-row input[type="file"]::-webkit-file-upload-button {
            background: rgba(100, 160, 255, 0.15);
            border: none;
            border-radius: 6px;
            color: #7eceff;
            padding: 0.3rem 0.7rem;
            cursor: pointer;
            font-size: 0.82rem;
        }
        .btn-import {
            background: rgba(100, 160, 255, 0.2);
            border: 1px solid rgba(100, 160, 255, 0.4);
            border-radius: 8px;
            color: #7eceff;
            padding: 0.55rem 1.2rem;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.88rem;
            white-space: nowrap;
            transition: background 0.2s;
        }
        .btn-import:hover { background: rgba(100, 160, 255, 0.35); }

        /* Flash messages */
        .flash-ok {
            background: rgba(50,200,100,0.1);
            border: 1px solid rgba(50,200,100,0.3);
            border-radius: 8px;
            color: #6effa0;
            padding: 0.6rem 0.9rem;
            font-size: 0.83rem;
        }
        .flash-err {
            background: rgba(255,80,80,0.1);
            border: 1px solid rgba(255,80,80,0.3);
            border-radius: 8px;
            color: #ff9090;
            padding: 0.6rem 0.9rem;
            font-size: 0.83rem;
            margin-top: 0.4rem;
        }

        @media (max-width: 768px) {
            main { margin-left: 0; padding: 1rem; }
            .import-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
    <x-sidebar />

    <main>
        <h1>📥 Importar Datos</h1>
        <p class="subtitle">Sube archivos Excel (.xlsx, .xls) o CSV para poblar la base de datos. Los registros existentes se actualizan automáticamente.</p>

        {{-- Orden de importación --}}
        <div class="orden-banner">
            <strong>⚠️ Orden recomendado de importación (por dependencias entre tablas):</strong>
            <ol>
                <li>Programas Académicos</li>
                <li>Planes Académicos <em>(requiere: Programas)</em></li>
                <li>Softwares &amp; Profesores <em>(sin dependencias)</em></li>
                <li>Estudiantes <em>(requiere: Programas)</em></li>
                <li>Materias <em>(requiere: Planes + Categorías — estas últimas se crean automáticamente)</em></li>
            </ol>
        </div>

        <div class="import-grid">

            {{-- ── 1. PROGRAMAS ACADÉMICOS ─────────────────────────────────── --}}
            <div class="import-card">
                <h2>🎓 Programas Académicos <span class="badge">Sin dependencias</span></h2>
                <p class="desc">Catálogo base de carreras. Ej: "Licenciatura en Multimedia y Animación Digital".</p>

                <table class="format-table">
                    <tr><th>Columna</th><th>Tipo</th><th>Ejemplo</th></tr>
                    <tr><td><code>nombre</code></td>       <td class="req">Requerido</td><td>Licenciatura en Multimedia y Animación Digital</td></tr>
                    <tr><td><code>abreviatura</code></td>  <td class="req">Requerido</td><td>LMAD</td></tr>
                    <tr><td><code>descripcion</code></td>  <td class="opt">Opcional</td> <td>Descripción breve</td></tr>
                </table>

                @if(session('import_success_programas'))
                    <div class="flash-ok">{{ session('import_success_programas') }}</div>
                @endif
                @if(session('import_errors_programas'))
                    <div class="flash-err">⚠️ {{ session('import_errors_programas') }}</div>
                @endif

                <form action="{{ route('admin.importar.programas') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="upload-row">
                        <input type="file" name="archivo" accept=".xlsx,.xls,.csv" required>
                        <button type="submit" class="btn-import">Importar</button>
                    </div>
                </form>
            </div>

            {{-- ── 2. PLANES ACADÉMICOS ────────────────────────────────────── --}}
            <div class="import-card">
                <h2>📋 Planes Académicos <span class="badge dep">Requiere: Programas</span></h2>
                <p class="desc">Planes de estudio dentro de cada programa. Ej: "Plan 2019" perteneciente a "LMAD".</p>

                <table class="format-table">
                    <tr><th>Columna</th><th>Tipo</th><th>Ejemplo</th></tr>
                    <tr><td><code>nombre</code></td>               <td class="req">Requerido</td><td>Plan 2019</td></tr>
                    <tr><td><code>programa_abreviatura</code></td> <td class="req">Requerido</td><td>LMAD</td></tr>
                </table>

                @if(session('import_success_planes'))
                    <div class="flash-ok">{{ session('import_success_planes') }}</div>
                @endif
                @if(session('import_errors_planes'))
                    <div class="flash-err">⚠️ {{ session('import_errors_planes') }}</div>
                @endif

                <form action="{{ route('admin.importar.planes') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="upload-row">
                        <input type="file" name="archivo" accept=".xlsx,.xls,.csv" required>
                        <button type="submit" class="btn-import">Importar</button>
                    </div>
                </form>
            </div>

            {{-- ── 3. SOFTWARES ────────────────────────────────────────────── --}}
            <div class="import-card">
                <h2>💾 Softwares <span class="badge">Sin dependencias</span></h2>
                <p class="desc">Catálogo de herramientas y softwares que los proyectos pueden usar.</p>

                <table class="format-table">
                    <tr><th>Columna</th><th>Tipo</th><th>Ejemplo</th></tr>
                    <tr><td><code>nombre</code></td>      <td class="req">Requerido</td><td>Unity 2022</td></tr>
                    <tr><td><code>descripcion</code></td> <td class="opt">Opcional</td> <td>Motor de videojuegos</td></tr>
                </table>

                @if(session('import_success_softwares'))
                    <div class="flash-ok">{{ session('import_success_softwares') }}</div>
                @endif
                @if(session('import_errors_softwares'))
                    <div class="flash-err">⚠️ {{ session('import_errors_softwares') }}</div>
                @endif

                <form action="{{ route('admin.importar.softwares') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="upload-row">
                        <input type="file" name="archivo" accept=".xlsx,.xls,.csv" required>
                        <button type="submit" class="btn-import">Importar</button>
                    </div>
                </form>
            </div>

            {{-- ── 4. PROFESORES ───────────────────────────────────────────── --}}
            <div class="import-card">
                <h2>👩‍🏫 Padrón de Profesores <span class="badge">Sin dependencias</span></h2>
                <p class="desc">Lista oficial de profesores UANL. Los registros existentes (por número de empleado) se actualizan.</p>

                <table class="format-table">
                    <tr><th>Columna</th><th>Tipo</th><th>Ejemplo</th></tr>
                    <tr><td><code>numero_empleado</code></td>   <td class="req">Requerido</td><td>123456</td></tr>
                    <tr><td><code>nombre</code></td>            <td class="req">Requerido</td><td>María</td></tr>
                    <tr><td><code>apellido_paterno</code></td>  <td class="req">Requerido</td><td>González</td></tr>
                    <tr><td><code>apellido_materno</code></td>  <td class="opt">Opcional</td> <td>López</td></tr>
                    <tr><td><code>email</code></td>             <td class="opt">Opcional</td> <td>mgonzalez@uanl.mx</td></tr>
                </table>

                @if(session('import_success_profesores'))
                    <div class="flash-ok">{{ session('import_success_profesores') }}</div>
                @endif
                @if(session('import_errors_profesores'))
                    <div class="flash-err">⚠️ {{ session('import_errors_profesores') }}</div>
                @endif

                <form action="{{ route('admin.importar.profesores') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="upload-row">
                        <input type="file" name="archivo" accept=".xlsx,.xls,.csv" required>
                        <button type="submit" class="btn-import">Importar</button>
                    </div>
                </form>
            </div>

            {{-- ── 5. ESTUDIANTES ──────────────────────────────────────────── --}}
            <div class="import-card">
                <h2>🎒 Padrón de Estudiantes <span class="badge dep">Requiere: Programas</span></h2>
                <p class="desc">Lista oficial de alumnos inscritos. Los registros existentes (por matrícula) se actualizan.</p>

                <table class="format-table">
                    <tr><th>Columna</th><th>Tipo</th><th>Ejemplo</th></tr>
                    <tr><td><code>matricula</code></td>            <td class="req">Requerido</td><td>1985623</td></tr>
                    <tr><td><code>nombre</code></td>               <td class="req">Requerido</td><td>Carlos</td></tr>
                    <tr><td><code>apellido_paterno</code></td>     <td class="req">Requerido</td><td>Ramírez</td></tr>
                    <tr><td><code>apellido_materno</code></td>     <td class="opt">Opcional</td> <td>Torres</td></tr>
                    <tr><td><code>semestre</code></td>             <td class="req">Requerido</td><td>5</td></tr>
                    <tr><td><code>email</code></td>                <td class="opt">Opcional</td> <td>1985623@uanl.edu.mx</td></tr>
                    <tr><td><code>programa_abreviatura</code></td> <td class="req">Requerido</td><td>LMAD</td></tr>
                </table>

                @if(session('import_success_estudiantes'))
                    <div class="flash-ok">{{ session('import_success_estudiantes') }}</div>
                @endif
                @if(session('import_errors_estudiantes'))
                    <div class="flash-err">⚠️ {{ session('import_errors_estudiantes') }}</div>
                @endif

                <form action="{{ route('admin.importar.estudiantes') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="upload-row">
                        <input type="file" name="archivo" accept=".xlsx,.xls,.csv" required>
                        <button type="submit" class="btn-import">Importar</button>
                    </div>
                </form>
            </div>

            {{-- ── 6. MATERIAS ─────────────────────────────────────────────── --}}
            <div class="import-card">
                <h2>📚 Materias <span class="badge dep">Requiere: Planes + Programas</span></h2>
                <p class="desc">
                    Catálogo completo de materias por plan académico.
                    Las categorías se crean automáticamente si no existen.
                </p>

                <table class="format-table">
                    <tr><th>Columna</th><th>Tipo</th><th>Ejemplo</th></tr>
                    <tr><td><code>clave</code></td>                <td class="opt">Opcional</td> <td>FCFM-101</td></tr>
                    <tr><td><code>nombre</code></td>               <td class="req">Requerido</td><td>Desarrollo de Videojuegos</td></tr>
                    <tr><td><code>abreviatura</code></td>          <td class="opt">Opcional</td> <td>DVJ</td></tr>
                    <tr><td><code>descripcion</code></td>          <td class="opt">Opcional</td> <td>Materia de 5° semestre</td></tr>
                    <tr><td><code>creditos</code></td>             <td class="req">Requerido</td><td>8</td></tr>
                    <tr><td><code>semestre</code></td>             <td class="req">Requerido</td><td>5</td></tr>
                    <tr><td><code>plan_nombre</code></td>          <td class="req">Requerido</td><td>Plan 2019</td></tr>
                    <tr><td><code>programa_abreviatura</code></td> <td class="req">Requerido</td><td>LMAD</td></tr>
                    <tr><td><code>categoria_nombre</code></td>     <td class="req">Requerido</td><td>Videojuegos</td></tr>
                </table>

                @if(session('import_success_materias'))
                    <div class="flash-ok">{{ session('import_success_materias') }}</div>
                @endif
                @if(session('import_errors_materias'))
                    <div class="flash-err">⚠️ {{ session('import_errors_materias') }}</div>
                @endif

                <form action="{{ route('admin.importar.materias') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="upload-row">
                        <input type="file" name="archivo" accept=".xlsx,.xls,.csv" required>
                        <button type="submit" class="btn-import">Importar</button>
                    </div>
                </form>
            </div>

        </div>{{-- /import-grid --}}
    </main>

</body>
</html>
