<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Backup - Admin EXPO LMAD</title>

    @vite([
        'resources/css/guest/template.css',
    ])

    <style>
        main {
            margin-left: 260px;
            padding: 2rem 2.5rem;
            color: var(--white, #fff);
            min-height: 100vh;
        }
        main h1 { font-size: 2rem; margin-bottom: 0.4rem; }
        .subtitle { color: var(--gray, #8899aa); font-size: 0.9rem; margin-bottom: 2rem; }

        .backup-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .backup-card {
            background: var(--blue-950, #050e20);
            border: 1px solid var(--blue-600, #1e3a5f);
            border-radius: 16px;
            padding: 1.6rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .backup-card-header {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        .backup-icon {
            font-size: 1.5rem;
            width: 44px; height: 44px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: rgba(108,71,182,0.15);
            border: 1px solid rgba(108,71,182,0.35);
            flex-shrink: 0;
        }
        .backup-icon.blue {
            background: rgba(59,125,216,0.15);
            border-color: rgba(59,125,216,0.35);
        }
        .backup-icon.red {
            background: rgba(220,50,50,0.15);
            border-color: rgba(220,50,50,0.35);
        }
        .backup-card h2 { font-size: 1.05rem; font-weight: 700; margin: 0; }
        .backup-card p  { font-size: 0.85rem; color: var(--gray, #8899aa); margin: 0; line-height: 1.55; }

        .backup-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.4rem;
            border-radius: 50px;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: opacity 0.2s;
        }
        .backup-btn:hover { opacity: 0.85; }
        .btn-purple { background: linear-gradient(135deg, #6c47b6, #4a7fd4); color: #fff; }
        .btn-blue   { background: linear-gradient(135deg, #1e5aaa, #2e7dd4); color: #fff; }
        .btn-danger { background: rgba(220,50,50,0.2); color: #ff8a8a; border: 1px solid rgba(220,50,50,0.4); }

        .warning-box {
            background: rgba(220,100,50,0.1);
            border: 1px solid rgba(220,100,50,0.35);
            border-radius: 10px;
            padding: 0.9rem 1.1rem;
            font-size: 0.82rem;
            color: #ffaa77;
            line-height: 1.55;
        }
        .warning-box strong { color: #ffcc99; display: block; margin-bottom: 0.3rem; }

        .msg-ok  { background: rgba(50,200,100,0.12); border: 1px solid rgba(50,200,100,0.3); color: #6effa8; border-radius: 10px; padding: 0.8rem 1.1rem; font-size: 0.88rem; margin-bottom: 1.5rem; }
        .msg-err { background: rgba(220,50,50,0.12);  border: 1px solid rgba(220,50,50,0.3);  color: #ff8a8a; border-radius: 10px; padding: 0.8rem 1.1rem; font-size: 0.88rem; margin-bottom: 1.5rem; }

        .divider { height: 1px; background: rgba(255,255,255,0.06); margin: 0.6rem 0; }

        input[type="file"] {
            display: block;
            background: rgba(255,255,255,0.05);
            border: 1px dashed rgba(108,71,182,0.5);
            border-radius: 8px;
            padding: 0.6rem 0.8rem;
            color: var(--gray, #8899aa);
            font-size: 0.85rem;
            width: 100%;
            box-sizing: border-box;
            cursor: pointer;
        }

        .info-steps {
            list-style: none;
            padding: 0; margin: 0;
            counter-reset: steps;
        }
        .info-steps li {
            counter-increment: steps;
            display: flex;
            align-items: flex-start;
            gap: 0.7rem;
            font-size: 0.82rem;
            color: var(--gray, #8899aa);
            padding: 0.3rem 0;
            line-height: 1.5;
        }
        .info-steps li::before {
            content: counter(steps);
            display: flex; align-items: center; justify-content: center;
            min-width: 20px; height: 20px;
            border-radius: 50%;
            background: rgba(108,71,182,0.25);
            border: 1px solid rgba(108,71,182,0.4);
            font-size: 0.72rem;
            color: #a78bfa;
            font-weight: 700;
            flex-shrink: 0;
            margin-top: 1px;
        }

        @media (max-width: 800px) {
            main { margin-left: 0; padding: 5rem 1.2rem 2rem; }
        }
    </style>
</head>

<body>
    <x-sidebar />

    <main>
        <h1>Backup de datos</h1>
        <p class="subtitle">Exporta e importa la base de datos y los archivos subidos por los usuarios.</p>

        @if(session('backup_exito'))
            <div class="msg-ok">✓ {{ session('backup_exito') }}</div>
        @endif
        @if(session('backup_error'))
            <div class="msg-err">✗ {{ session('backup_error') }}</div>
        @endif
        @if($errors->any())
            <div class="msg-err">✗ {{ $errors->first() }}</div>
        @endif

        <div class="backup-grid">

            {{-- ── EXPORTAR BD ──────────────────────────────────────── --}}
            <div class="backup-card">
                <div class="backup-card-header">
                    <div class="backup-icon">🗄️</div>
                    <div>
                        <h2>Exportar base de datos</h2>
                    </div>
                </div>
                <p>
                    Descarga un archivo <strong>.sql</strong> con el esquema y todos los datos
                    actuales de la BD. Úsalo para migrar a otro servidor o como respaldo.
                </p>
                <div class="divider"></div>
                <ul class="info-steps">
                    <li>El archivo incluye CREATE TABLE + todos los INSERT</li>
                    <li>Compatible con MySQL / MariaDB</li>
                    <li>Se genera en tiempo real, sin dependencia de mysqldump</li>
                </ul>
                <div>
                    <a href="{{ route('admin.backup.exportar-sql') }}" class="backup-btn btn-purple">
                        ⬇ Descargar .sql
                    </a>
                </div>
            </div>

            {{-- ── EXPORTAR STORAGE ──────────────────────────────────── --}}
            <div class="backup-card">
                <div class="backup-card-header">
                    <div class="backup-icon blue">📦</div>
                    <div>
                        <h2>Exportar archivos (storage)</h2>
                    </div>
                </div>
                <p>
                    Descarga un <strong>.zip</strong> con todos los archivos multimedia subidos
                    (pósters, imágenes de proyectos, etc.) desde <code>storage/app/public</code>.
                </p>
                <div class="divider"></div>
                <ul class="info-steps">
                    <li>Incluye todos los archivos del storage público</li>
                    <li>Al mover de host, extrae el ZIP en el mismo directorio</li>
                    <li>Las rutas en BD seguirán siendo válidas</li>
                </ul>
                <div>
                    <a href="{{ route('admin.backup.exportar-storage') }}" class="backup-btn btn-blue">
                        ⬇ Descargar .zip
                    </a>
                </div>
            </div>

            {{-- ── IMPORTAR BD ──────────────────────────────────────── --}}
            <div class="backup-card">
                <div class="backup-card-header">
                    <div class="backup-icon red">⚠️</div>
                    <div>
                        <h2>Importar base de datos</h2>
                    </div>
                </div>
                <div class="warning-box">
                    <strong>Acción destructiva — úsala con precaución</strong>
                    El archivo SQL se ejecuta directamente contra la BD actual.
                    Haz una exportación antes de importar para no perder datos.
                </div>
                <p>Sube un archivo <strong>.sql</strong> generado desde esta misma herramienta o desde mysqldump.</p>
                <form action="{{ route('admin.backup.importar-sql') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="archivo_sql" accept=".sql,.txt" required style="margin-bottom:1rem;">
                    <button type="submit" class="backup-btn btn-danger">
                        ⬆ Importar y ejecutar SQL
                    </button>
                </form>
            </div>

        </div>

        {{-- Instrucciones de migración --}}
        <div class="backup-card" style="max-width: 720px;">
            <div class="backup-card-header">
                <div class="backup-icon">📋</div>
                <div><h2>Cómo migrar entre servidores</h2></div>
            </div>
            <p style="margin-bottom:0.8rem;">Pasos recomendados para pasar el proyecto de un host a otro:</p>
            <ul class="info-steps">
                <li>Exporta la BD con el botón de arriba y guarda el <code>.sql</code></li>
                <li>Exporta el storage y guarda el <code>.zip</code></li>
                <li>En el nuevo servidor, configura el <code>.env</code> con la nueva conexión a BD</li>
                <li>Ejecuta <code>php artisan migrate</code> para crear las tablas (o importa el SQL directamente)</li>
                <li>Descomprime el ZIP del storage en <code>storage/app/public/</code></li>
                <li>Ejecuta <code>php artisan storage:link</code> para crear el enlace simbólico</li>
                <li>Verifica que <code>APP_URL</code> en <code>.env</code> apunte al nuevo dominio</li>
            </ul>
        </div>

    </main>
</body>
</html>
