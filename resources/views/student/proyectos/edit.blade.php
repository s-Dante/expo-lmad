<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $proyecto->titulo ? 'Editar Proyecto' : 'Registro de Proyecto' }} - Expo LMAD</title>
    
    {{-- Estilos del Sidebar --}}
    @vite(['resources/css/components/sidebar.css'])

    <style>
        :root {
            --primary: #2563eb;       /* blue-600 */
            --primary-hover: #1d4ed8; /* blue-700 */
            --danger: #ef4444;        /* red-500 */
            --danger-bg: #fef2f2;     /* red-50 */
            --danger-border: #fecaca; /* red-200 */
            --warning: #eab308;       /* yellow-500 */
            --warning-bg: #fefce8;    /* yellow-50 */
            --warning-border: #fef08a;/* yellow-200 */
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, sans-serif;
            background-color: var(--gray-100);
            color: var(--gray-800);
        }

        .layout-container { display: flex; min-height: 100vh; }
        
        .main-content {
            flex: 1;
            padding: 2rem;
            transition: margin-left 0.3s ease;
            width: 100%;
        }

        @media (min-width: 768px) {
            .main-content { margin-left: 16rem; }
        }

        .container { max-width: 64rem; margin: 0 auto; } /* max-w-5xl */

        .breadcrumbs {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            color: var(--gray-500);
            margin-bottom: 1.5rem;
            list-style: none;
            padding: 0;
        }
        .breadcrumbs a { text-decoration: none; color: inherit; transition: color 0.2s; }
        .breadcrumbs a:hover { color: var(--primary); }
        .breadcrumbs .separator { margin: 0 0.5rem; }
        .breadcrumbs .current { font-weight: 600; color: var(--gray-700); }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 2rem;
        }
        .page-title h1 {
            font-size: 1.875rem; font-weight: 800; color: var(--gray-900); margin: 0; letter-spacing: -0.025em;
        }
        .page-title p { color: var(--gray-500); margin-top: 0.5rem; }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .alert-danger {
            background-color: var(--danger-bg);
            border-color: var(--danger);
            color: #b91c1c;
        }
        .alert-content { display: flex; }
        .alert-icon { width: 1.5rem; height: 1.5rem; color: var(--danger); flex-shrink: 0; }
        .alert-body { margin-left: 1rem; }
        .alert-title { font-weight: 700; color: #991b1b; margin: 0; font-size: 1.125rem; }
        .alert-text { margin-top: 0.25rem; font-size: 0.875rem; }

        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: .9; }
        }
        .animate-pulse { animation: pulse-slow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }

        .card {
            background-color: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-200);
            margin-bottom: 2rem;
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            padding-bottom: 0.5rem;
        }
        .card-title { font-size: 1.25rem; font-weight: 700; color: var(--gray-800); margin: 0; }

        .form-grid { display: grid; grid-template-columns: 1fr; gap: 1.5rem; }
        .form-grid-12 { display: grid; grid-template-columns: 1fr; gap: 2rem; }
        
        @media (min-width: 768px) {
            .form-grid-12 { grid-template-columns: repeat(12, 1fr); }
            .col-span-4 { grid-column: span 4; }
            .col-span-8 { grid-column: span 8; }
        }

        .form-group { margin-bottom: 0; }
        
        .label {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }
        .required { color: var(--danger); margin-left: 0.25rem; }

        .input-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            background-color: var(--gray-50);
            transition: all 0.2s;
            font-size: 1rem;
        }
        .input-control:focus {
            outline: none;
            background-color: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
        }
        textarea.input-control { resize: vertical; min-height: 120px; }

        .input-youtube-wrapper { position: relative; }
        .input-icon-left {
            position: absolute; top: 0; bottom: 0; left: 0;
            padding-left: 0.75rem; display: flex; align-items: center; pointer-events: none;
        }
        .input-youtube {
            padding-left: 2.5rem;
            background-color: #fef2f2;
            border-color: #fecaca;
            color: #7f1d1d;
        }
        .input-youtube:focus {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
            background-color: white;
        }

        .input-icon-control { padding-left: 2.5rem; }
        .input-drive { background-color: #eff6ff; border-color: #bfdbfe; color: #1e3a8a; }
        .input-drive:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2); }

        .image-upload-container {
            display: flex; flex-direction: column; align-items: center;
        }
        .image-preview-box {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1;
            background-color: var(--gray-100);
            border-radius: 0.75rem;
            border: 2px dashed var(--gray-300);
            overflow: hidden;
            cursor: pointer;
            transition: border-color 0.2s;
        }
        .image-preview-box:hover { border-color: var(--primary); }
        
        .preview-img { width: 100%; height: 100%; object-fit: cover; }
        
        .upload-overlay {
            position: absolute; inset: 0;
            background-color: rgba(0,0,0,0.4);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; transition: opacity 0.2s;
        }
        .image-preview-box:hover .upload-overlay { opacity: 1; }
        
        .overlay-text {
            background-color: rgba(0,0,0,0.6); color: white;
            font-weight: 700; font-size: 0.875rem;
            padding: 0.5rem 1rem; border-radius: 0.25rem;
        }

        .btn-upload {
            margin-top: 1rem;
            width: 100%;
            padding: 0.5rem;
            background-color: var(--gray-100);
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            font-weight: 700; color: var(--gray-700);
            font-size: 0.875rem;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.2s;
        }
        .btn-upload:hover { background-color: var(--gray-200); }

        .tech-search {
            width: 100%; padding: 0.5rem 1rem;
            border: 1px solid var(--gray-300); border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .tech-container {
            display: flex; flex-wrap: wrap; gap: 0.5rem;
            max-height: 15rem; overflow-y: auto;
            padding: 0.5rem;
            border: 1px solid var(--gray-100);
            border-radius: 0.5rem;
            background-color: var(--gray-50);
        }

        .tech-item input[type="checkbox"] { display: none; }
        
        .tech-badge {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem; font-weight: 500;
            border: 1px solid var(--gray-300);
            background-color: white; color: var(--gray-500);
            cursor: pointer; user-select: none;
            transition: all 0.2s;
        }
        
        .tech-item:hover .tech-badge { border-color: var(--primary); color: var(--primary); }
        
        .tech-item input[type="checkbox"]:checked + .tech-badge {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary-hover);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .confirmation-card {
            background-color: var(--warning-bg);
            border: 1px solid var(--warning-border);
            border-radius: 0.75rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .confirmation-grid {
            display: flex; flex-direction: column; gap: 2rem;
        }
        @media (min-width: 768px) { .confirmation-grid { flex-direction: row; } }

        .token-input {
            width: 100%; padding: 0.75rem 1rem;
            border: 1px solid var(--gray-300); border-radius: 0.5rem;
            font-family: monospace; letter-spacing: 0.1em; text-transform: uppercase;
            font-size: 1.125rem;
        }
        .token-input:focus {
            outline: none; border-color: var(--warning);
            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.2);
        }

        .checkbox-wrapper {
            display: flex; align-items: center;
            padding: 1rem;
            background-color: white;
            border: 1px solid #fef9c3; /* yellow-100 */
            border-radius: 0.5rem;
            cursor: pointer;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
            transition: shadow 0.2s;
        }
        .checkbox-wrapper:hover { box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        
        .custom-checkbox {
            width: 1.5rem; height: 1.5rem;
            border-radius: 0.25rem;
            color: #16a34a; /* green-600 */
            cursor: pointer;
        }

        .actions-footer {
            display: flex; justify-content: flex-end; gap: 1rem;
            padding-top: 1rem; border-top: 1px solid var(--gray-200);
        }

        .btn {
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex; align-items: center; justify-content: center;
            border: none; font-size: 1rem;
        }

        .btn-cancel {
            background-color: white; color: var(--gray-700);
            border: 1px solid var(--gray-300);
        }
        .btn-cancel:hover { background-color: var(--gray-50); }

        .btn-save {
            background-color: var(--primary); color: white;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }
        .btn-save:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
        }

        .tooltip { position: relative; display: inline-flex; margin-left: 0.5rem; color: var(--gray-400); cursor: help; }
        .tooltip:hover { color: var(--primary); }
        .tooltip svg { width: 1rem; height: 1rem; }
        
        .tooltip-text {
            visibility: hidden; width: 220px;
            background-color: var(--gray-800); color: #fff;
            text-align: center; border-radius: 6px; padding: 8px;
            position: absolute; z-index: 50;
            bottom: 125%; left: 50%; margin-left: -110px;
            opacity: 0; transition: opacity 0.3s;
            font-size: 0.75rem; font-weight: normal;
            pointer-events: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .tooltip-text::after {
            content: ""; position: absolute; top: 100%; left: 50%; margin-left: -5px;
            border-width: 5px; border-style: solid; border-color: var(--gray-800) transparent transparent transparent;
        }
        .tooltip:hover .tooltip-text { visibility: visible; opacity: 1; }

        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    </style>
</head>
<body>

    <div class="layout-container">
        
        <x-sidebar />

        <main class="main-content">
            <div class="container">
                
                {{-- 
                    Breadcrumbs 
                        Se pueden quitar xd solo era para que regrese jajajaj
                --}}
                <nav>
                    <ol class="breadcrumbs">
                        <li><a href="{{ route('estudiante.dashboard') }}">Dashboard</a></li>
                        <li class="separator">/</li>
                        <li><a href="{{ route('estudiante.proyectos.index') }}">Mis Proyectos</a></li>
                        <li class="separator">/</li>
                        <li class="current">{{ $proyecto->titulo ? 'Editar' : 'Registrar' }}</li>
                    </ol>
                </nav>

                {{-- 
                    ALERTA DE RECHAZO 
                    Aqui se muestra el mensaje de porque se le rechazo el proyecto
                --}}
                @if($proyecto->estatus === 'rechazado' && $proyecto->retroalimentacion)
                    <div class="alert alert-danger animate-pulse">
                        <div class="alert-content">
                            <svg class="alert-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="alert-body">
                                <h3 class="alert-title">Correcciones Necesarias</h3>
                                <p class="alert-text">{{ $proyecto->retroalimentacion }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Encabezado --}}
                <div class="page-header">
                    <div class="page-title">
                        <h1>{{ $proyecto->titulo ? 'Editar Información del Proyecto' : 'Registro de Nuevo Proyecto' }}</h1>
                        <p>Completa todos los campos requeridos para la evaluación de tu proyecto.</p>
                    </div>
                </div>

                {{-- Errores --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <p style="font-weight:700; margin-bottom:0.5rem">Se encontraron errores en el formulario:</p>
                        <ul style="margin:0; padding-left:1.5rem; font-size:0.875rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- 
                    FORMULARIO 
                        Esta es la seccion donde se llena toda la informacion del proyecto
                --}}
                <form action="{{ route('estudiante.proyectos.update', $proyecto->id) }}" method="POST" enctype="multipart/form-data" id="projectForm">
                    @csrf
                    @method('PUT')

                    {{-- 1. INFORMACIÓN GENERAL --}}
                    <section class="card">
                        <div class="card-header">
                            <h2 class="card-title">1. Información General</h2>
                        </div>
                        
                        <div class="form-grid">
                            {{-- Título --}}
                            <div class="form-group">
                                <label class="label">
                                    Título del Proyecto <span class="required">*</span>
                                    <div class="tooltip">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="tooltip-text">El nombre oficial de tu proyecto. Debe ser corto y descriptivo.</span>
                                    </div>
                                </label>
                                <input type="text" name="titulo" value="{{ old('titulo', $proyecto->titulo) }}" 
                                       class="input-control" 
                                       placeholder="Ej: Sistema de Gestión con IA" required>
                            </div>

                            {{-- Descripción --}}
                            <div class="form-group">
                                <label class="label">
                                    Descripción Detallada <span class="required">*</span>
                                    <div class="tooltip">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="tooltip-text">Explica brevemente tu proyecto, para dar contexto sobre el.</span>
                                    </div>
                                </label>
                                <textarea name="descripcion" class="input-control" 
                                          placeholder="Describe el proyecto y su funcionalidad..." required>{{ old('descripcion', $proyecto->descripcion) }}</textarea>
                            </div>
                        </div>
                    </section>

                    {{-- 2. MULTIMEDIA --}}
                    <section class="card">
                        <div class="card-header">
                            <h2 class="card-title">2. Multimedia y Enlaces</h2>
                        </div>
                        
                        <div class="form-grid-12">
                            
                            {{-- Columna Izquierda: Imagen (4 cols) --}}
                            <div class="col-span-4 image-upload-container">
                                <label class="label" style="align-self: flex-start;">
                                    Portada <span class="required">*</span>
                                    <div class="tooltip">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="tooltip-text">Imagen cuadrada (1:1). Máx 5MB.</span>
                                    </div>
                                </label>

                                @php
                                    $portada = $proyecto->multimedia->where('es_portada', true)->first();
                                    $defaultImg = 'https://via.placeholder.com/300x300?text=Subir+Imagen';
                                    $currentImg = $portada ? asset('storage/' . $portada->url) : $defaultImg;
                                @endphp
                                
                                <div class="image-preview-box" onclick="document.getElementById('posterInput').click()">
                                    <img id="previewImage" src="{{ $currentImg }}" class="preview-img">
                                    <div class="upload-overlay">
                                        <span class="overlay-text">Cambiar Imagen</span>
                                    </div>
                                </div>

                                <input type="file" name="poster" id="posterInput" accept="image/*" style="display:none;" onchange="previewFile(this)">
                                
                                <button type="button" onclick="document.getElementById('posterInput').click()" class="btn-upload">
                                    <svg style="width:1rem; height:1rem; margin-right:0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Seleccionar Archivo
                                </button>
                                <p style="font-size:0.75rem; color:var(--gray-400); margin-top:0.5rem;">Máx 5MB (JPG/PNG)</p>
                            </div>

                            {{-- Columna Derecha: Enlaces (8 cols) --}}
                            <div class="col-span-8">
                                <div class="form-grid">
                                    {{-- YouTube --}}
                                    <div class="form-group">
                                        <label class="label">
                                            Video Demo (YouTube) <span class="required">*</span>
                                        </label>
                                        <div class="input-youtube-wrapper">
                                            <span class="input-icon-left" style="color:var(--danger)">
                                                <svg style="width:1.25rem; height:1.25rem;" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                            </span>
                                            @php $youtube = $proyecto->multimedia->where('tipo', 'youtube')->first(); @endphp
                                            <input type="url" name="link_youtube" value="{{ old('link_youtube', $youtube?->url) }}" 
                                                   class="input-control input-youtube"
                                                   placeholder="https://www.youtube.com/watch?v=..." required>
                                        </div>
                                    </div>

                                    {{-- Drive --}}
                                    <div class="form-group">
                                        <label class="label">Google Drive (Documentación)</label>
                                        <div class="input-youtube-wrapper">
                                            <span class="input-icon-left" style="color:var(--primary)">
                                                <svg style="width:1.25rem; height:1.25rem;" fill="currentColor" viewBox="0 0 24 24"><path d="M12.01 1.485c2.082 0 3.754.02 3.743.047.01.02 1.708 2.981 3.784 6.57l.035.063H12.01L4.444 21.28c-.027.047-.04.047-.075.006-.046-.056-6.19-10.742-3.793-14.896C2.378 2.593 10.37 1.485 12.01 1.485z"/></svg>
                                            </span>
                                            @php $drive = $proyecto->multimedia->where('tipo', 'drive')->first(); @endphp
                                            <input type="url" name="link_drive" value="{{ old('link_drive', $drive?->url) }}" 
                                                   class="input-control input-icon-control input-drive"
                                                   placeholder="Enlace a Drive (Opcional)">
                                        </div>
                                    </div>

                                    {{-- GitHub --}}
                                    <div class="form-group">
                                        <label class="label">GitHub (Código Fuente)</label>
                                        <div class="input-youtube-wrapper">
                                            <span class="input-icon-left" style="color:var(--gray-700)">
                                                <svg style="width:1.25rem; height:1.25rem;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416 0 0-1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                            </span>
                                            @php $github = $proyecto->multimedia->where('tipo', 'github')->first(); @endphp
                                            <input type="url" name="link_github" value="{{ old('link_github', $github?->url) }}" 
                                                   class="input-control input-icon-control"
                                                   placeholder="Enlace al repositorio (Opcional)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- 3. TECNOLOGÍAS --}}
                    <section class="card">
                        <div class="card-header">
                            <h2 class="card-title">3. Stack Tecnológico</h2>
                            <div class="tooltip">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="tooltip-text">Selecciona las herramientas usadas.</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="text" id="techSearch" placeholder="🔍 Buscar tecnología (Ej: Java, Figma...)" 
                                   class="tech-search">
                            
                            <div class="tech-container custom-scroll" id="techContainer">
                                @foreach($softwares as $software)
                                    @php
                                        $isChecked = in_array($software->id, old('softwares', $proyecto->softwares->pluck('id')->toArray()));
                                    @endphp
                                    <label class="tech-item" data-name="{{ strtolower($software->nombre) }}">
                                        <input type="checkbox" name="softwares[]" value="{{ $software->id }}" {{ $isChecked ? 'checked' : '' }}>
                                        <span class="tech-badge">{{ $software->nombre }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <p style="font-size:0.75rem; color:var(--gray-400); margin-top:0.5rem;">
                                ¿Falta alguna? Contacta a tu profesor.
                            </p>
                        </div>
                    </section>

                    {{-- 4. CONFIRMACIÓN --}}
                    <section class="confirmation-card">
                        <div class="confirmation-grid">
                            
                            {{-- Token --}}
                            <div style="flex:1;">
                                <label class="label">
                                    🔑 Token de Seguridad
                                    <div class="tooltip">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        <span class="tooltip-text">El código único enviado por correo.</span>
                                    </div>
                                </label>
                                <input type="text" name="codigo_acceso" class="token-input" placeholder="CÓDIGO-123" required>
                            </div>

                            {{-- Check Enviar --}}
                            <div style="flex:1; display:flex; flex-direction:column; justify-content:center;">
                                <label class="checkbox-wrapper" for="enviar_revision">
                                    <input type="checkbox" id="enviar_revision" name="enviar_revision" value="1" class="custom-checkbox">
                                    <div style="margin-left:0.75rem;">
                                        <span style="display:block; font-weight:700; color:var(--gray-800);">Finalizar y Enviar a Revisión</span>
                                        <span style="font-size:0.75rem; color:var(--gray-500);">Si no marcas esto, se guardará como <strong>Borrador</strong>.</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </section>

                    {{-- Botones --}}
                    <div class="actions-footer">
                        <a href="{{ route('estudiante.proyectos.index') }}" class="btn btn-cancel">Cancelar</a>
                        <button type="submit" class="btn btn-save">
                            <svg style="width:1.25rem; height:1.25rem; margin-right:0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Guardar Cambios
                        </button>
                    </div>

                </form>
            </div>
        </main>
    </div>
    
    @vite(['resources/js/components/sidebar.js'])

    <script>
        // 1. Preview
        function previewFile(input) {
            const preview = document.getElementById('previewImage');
            const file = input.files[0];
            const reader = new FileReader();
            reader.addEventListener("load", function () { preview.src = reader.result; }, false);
            if (file) reader.readAsDataURL(file);
        }

        // 2. Buscador Tech
        document.getElementById('techSearch').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const items = document.querySelectorAll('.tech-item');
            items.forEach(item => {
                const name = item.getAttribute('data-name');
                if (name.includes(searchText)) item.style.display = 'inline-block';
                else item.style.display = 'none';
            });
        });
    </script>
</body>
</html>