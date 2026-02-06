<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Proyecto - {{ $proyecto->titulo }}</title>
    
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
            --success: #22c55e;       /* green-500 */
            --success-bg: #f0fdf4;    /* green-50 */
            --success-border: #bbf7d0;/* green-200 */
            
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-800);
        }

        a { text-decoration: none; color: inherit; }

        /* --- LAYOUT --- */
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

        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .back-link {
            display: flex; align-items: center;
            color: var(--gray-500); font-weight: 500; font-size: 0.875rem;
            transition: color 0.2s;
        }
        .back-link:hover { color: var(--primary); }
        
        .icon-circle {
            background-color: white; border: 1px solid var(--gray-200);
            border-radius: 9999px; padding: 0.5rem; margin-right: 0.75rem;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .back-link:hover .icon-circle { border-color: #bfdbfe; background-color: #eff6ff; }
        .icon-sm { width: 1rem; height: 1rem; }

        .edit-link {
            font-size: 0.875rem; font-weight: 700;
            color: var(--primary); display: flex; align-items: center;
        }
        .edit-link:hover { text-decoration: underline; }

        .alert {
            background-color: var(--danger-bg);
            border-left: 4px solid var(--danger);
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-radius: 0 0.75rem 0.75rem 0;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            display: flex; align-items: flex-start;
        }
        .alert-icon { color: var(--danger); width: 1.5rem; height: 1.5rem; margin-right: 0.75rem; margin-top: 0.125rem; }
        .alert-title { font-weight: 700; color: #991b1b; font-size: 0.875rem; text-transform: uppercase; margin: 0; }
        .alert-desc { color: #b91c1c; font-size: 0.875rem; margin: 0.25rem 0 0 0; }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            align-items: start;
        }

        @media (min-width: 1024px) {
            /* 5 columnas izq (multimedia), 7 columnas der (info) -> Proporción 5:7 */
            .content-grid { grid-template-columns: 5fr 7fr; }
        }

        .media-column { display: flex; flex-direction: column; gap: 1.5rem; }

        .media-card {
            background-color: white;
            border: 1px solid var(--gray-200);
            border-radius: 1rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            padding: 0.5rem; /* Padding pequeño para el poster */
        }
        
        .poster-container {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1;
            background-color: var(--gray-100);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .poster-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.7s ease; }
        .poster-container:hover .poster-img { transform: scale(1.05); }

        .poster-overlay {
            position: absolute; inset: 0;
            background-color: rgba(0,0,0,0.3);
            backdrop-filter: blur(2px);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; transition: opacity 0.3s;
        }
        .poster-container:hover .poster-overlay { opacity: 1; }

        .btn-view {
            background-color: white; color: var(--gray-900);
            padding: 0.5rem 1rem; border-radius: 9999px;
            font-weight: 700; font-size: 0.875rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex; align-items: center;
            transform: translateY(10px); transition: transform 0.3s;
        }
        .poster-container:hover .btn-view { transform: translateY(0); }

        .video-card {
            background-color: white; padding: 1rem;
            border: 1px solid var(--gray-200);
            border-radius: 1rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        
        .card-label-row {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 0.75rem;
        }
        .label-text { font-size: 0.75rem; font-weight: 700; color: var(--gray-400); text-transform: uppercase; letter-spacing: 0.05em; }
        .youtube-tag { background-color: #fef2f2; color: #dc2626; font-size: 0.625rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-weight: 700; text-transform: uppercase; }

        .video-wrapper {
            width: 100%; aspect-ratio: 16 / 9;
            background-color: black; border-radius: 0.75rem; overflow: hidden;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.5);
        }
        .video-frame { width: 100%; height: 100%; border: none; }

        /* Stack Tech */
        .tech-card {
            background-color: white; padding: 1.25rem;
            border: 1px solid var(--gray-200); border-radius: 1rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .tech-list { display: flex; flex-wrap: wrap; gap: 0.5rem; }
        .tech-pill {
            display: inline-flex; align-items: center;
            padding: 0.375rem 0.75rem; border-radius: 0.5rem;
            font-size: 0.875rem; font-weight: 700;
            background-color: #f8fafc; color: #475569;
            border: 1px solid #e2e8f0;
            cursor: help; transition: all 0.2s;
        }
        .tech-pill:hover { background-color: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }

        /* Enlaces */
        .links-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
        
        .link-btn {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 1rem; text-align: center; border-radius: 0.75rem;
            transition: all 0.2s; border: 1px solid transparent;
        }
        .link-github { background-color: var(--gray-900); color: white; }
        .link-github:hover { background-color: var(--gray-800); }
        
        .link-drive { background-color: white; color: var(--primary); border-color: #bfdbfe; }
        .link-drive:hover { border-color: var(--primary); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        
        .link-icon { width: 1.5rem; height: 1.5rem; margin-bottom: 0.5rem; opacity: 0.8; }
        .link-btn:hover .link-icon { opacity: 1; }
        .link-text { font-size: 0.875rem; font-weight: 700; }

        /* --- COLUMNA DERECHA (INFO) --- */
        .info-column { display: flex; flex-direction: column; gap: 2rem; }

        .info-card {
            background-color: white; padding: 2rem;
            border: 1px solid var(--gray-200); border-radius: 1rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .project-header {
            display: flex; flex-direction: column; gap: 1rem;
            padding-bottom: 1.5rem; margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--gray-100);
        }
        @media (min-width: 768px) {
            .project-header { flex-direction: row; justify-content: space-between; align-items: flex-start; }
        }

        .project-title h1 {
            font-size: 1.875rem; font-weight: 800; color: var(--gray-900);
            line-height: 1.2; margin: 0; letter-spacing: -0.025em;
        }

        /* Badge Status */
        .status-badge {
            display: inline-flex; align-items: center;
            padding: 0.5rem 1rem; border-radius: 0.5rem;
            font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
            border: 1px solid transparent; flex-shrink: 0;
        }
        /* Colores Estatus */
        .status-aprobado { background-color: var(--success-bg); color: #15803d; border-color: var(--success-border); }
        .status-rechazado { background-color: var(--danger-bg); color: #b91c1c; border-color: var(--danger-border); }
        .status-borrador { background-color: var(--gray-100); color: var(--gray-600); border-color: var(--gray-200); }
        .status-enviado { background-color: var(--warning-bg); color: #a16207; border-color: var(--warning-border); }

        .prose-desc {
            font-size: 1.125rem; color: var(--gray-600); line-height: 1.75;
            white-space: pre-line;
        }

        /* Bloque Unificado (Equipo + Académico) */
        .unified-card {
            background-color: white;
            border: 1px solid var(--gray-200); border-radius: 1rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .section-header {
            background-color: var(--gray-50); padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
        }
        .section-title {
            font-size: 0.75rem; font-weight: 700; color: var(--gray-500);
            text-transform: uppercase; letter-spacing: 0.05em;
            display: flex; align-items: center; margin: 0;
        }

        .team-grid {
            display: grid; grid-template-columns: 1fr; gap: 1rem; padding: 1.5rem;
        }
        @media (min-width: 768px) { .team-grid { grid-template-columns: 1fr 1fr; } }

        .team-member {
            display: flex; align-items: center;
            padding: 0.75rem; border-radius: 0.75rem;
            border: 1px solid var(--gray-100);
        }
        .team-member.is-me { background-color: #eff6ff; border-color: #bfdbfe; }

        .avatar {
            width: 2.5rem; height: 2.5rem;
            background-color: white; border: 1px solid var(--gray-200);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 700; color: var(--gray-500);
            margin-right: 0.75rem; flex-shrink: 0;
        }

        .member-info { flex: 1; }
        .member-name-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.125rem; }
        .member-name { font-size: 0.875rem; font-weight: 700; color: var(--gray-800); }
        .member-matricula { display: block; font-size: 0.75rem; color: var(--gray-500); font-family: monospace; }
        
        .role-badge {
            font-size: 0.625rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
            padding: 0.125rem 0.375rem; border-radius: 999px;
        }
        .role-lider { background-color: var(--warning-bg); color: #854d0e; border: 1px solid var(--warning-border); }

        .academic-footer {
            background-color: #f8fafc; /* gray-50 slightly different */
            border-top: 1px solid var(--gray-200);
            padding: 1.5rem;
        }
        
        .academic-grid {
            display: grid; grid-template-columns: 1fr; gap: 1.5rem;
        }
        @media (min-width: 768px) { .academic-grid { grid-template-columns: repeat(3, 1fr); } }

        .academic-item span:first-child {
            display: block; font-size: 0.625rem; font-weight: 700; color: var(--gray-400); text-transform: uppercase; margin-bottom: 0.25rem;
        }
        .academic-val { font-size: 0.875rem; font-weight: 600; color: var(--gray-700); }
        .periodo-tag {
            background-color: white; border: 1px solid var(--gray-200);
            padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-family: monospace;
        }

        /* Tooltip CSS */
        .tech-tooltip { position: relative; }
        .tech-tooltip:hover::after {
            content: attr(data-tip);
            position: absolute; bottom: 125%; left: 50%; transform: translateX(-50%);
            background-color: var(--gray-800); color: white; padding: 0.375rem 0.625rem;
            border-radius: 0.375rem; font-size: 0.75rem; white-space: nowrap; z-index: 50;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); pointer-events: none;
        }
        .tech-tooltip:hover::before {
            content: ''; position: absolute; bottom: 115%; left: 50%; margin-left: -5px;
            border-width: 5px; border-style: solid; border-color: var(--gray-800) transparent transparent transparent; z-index: 50;
        }

    </style>
</head>
<body>

    <div class="layout-container">
        
        <x-sidebar />

        <main class="main-content">
            
            {{-- Navegación --}}
            <nav class="top-nav">
                <a href="{{ route('estudiante.proyectos.index') }}" class="back-link">
                    <span class="icon-circle">
                        <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </span>
                    Volver al listado
                </a>

                {{-- Edición (Si aplica) --}}
                @if(in_array($proyecto->estatus, ['borrador', 'rechazado']))
                    @php
                        $miParticipacion = $proyecto->autores->find(auth()->user()->estudiante->id);
                        $soyLider = $miParticipacion ? $miParticipacion->pivot->es_lider : false;
                    @endphp
                    @if($soyLider)
                        <a href="{{ route('estudiante.proyectos.edit', $proyecto->id) }}" class="edit-link">
                            <svg class="icon-sm" style="margin-right:0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Editar Información
                        </a>
                    @endif
                @endif
            </nav>

            {{-- Alerta Retroalimentación --}}
            @if($proyecto->estatus === 'rechazado' && $proyecto->retroalimentacion)
                <div class="alert">
                    <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        <h3 class="alert-title">Correcciones Requeridas</h3>
                        <p class="alert-desc">"{{ $proyecto->retroalimentacion }}"</p>
                    </div>
                </div>
            @endif

            {{-- Grid Principal (Media 5 / Info 7) --}}
            <div class="content-grid">
                
                {{-- COLUMNA 1 (Izquierda): MULTIMEDIA & TECH --}}
                <div class="media-column">
                    
                    {{-- 1. PÓSTER --}}
                    <div class="media-card">
                        @php $portada = $proyecto->multimedia->where('es_portada', true)->first(); @endphp
                        
                        @if($portada)
                            <div class="poster-container">
                                <img src="{{ asset('storage/' . $portada->url) }}" class="poster-img">
                                <a href="{{ asset('storage/' . $portada->url) }}" target="_blank" class="poster-overlay">
                                    <span class="btn-view">
                                        <svg class="icon-sm" style="margin-right:0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Ver Completo
                                    </span>
                                </a>
                            </div>
                        @else
                            <div class="poster-container" style="background-color:white; border:2px dashed var(--gray-300); display:flex; flex-direction:column; align-items:center; justify-content:center; color:var(--gray-400);">
                                <svg style="width:4rem; height:4rem; opacity:0.3; margin-bottom:0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span style="font-size:0.875rem; font-weight:500;">Sin póster cargado</span>
                            </div>
                        @endif
                    </div>

                    {{-- 2. VIDEO --}}
                    @php $video = $proyecto->multimedia->where('tipo', 'youtube')->first(); @endphp
                    @if($video)
                    <div class="video-card">
                        <div class="card-label-row">
                            <span class="label-text">Video Demo</span>
                            <span class="youtube-tag">YouTube</span>
                        </div>
                        <div class="video-wrapper">
                            <iframe class="video-frame" src="{{ $video->url }}" title="Video" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    @endif

                    {{-- 3. STACK TECH --}}
                    @if($proyecto->softwares->count() > 0)
                    <div class="tech-card">
                        <div class="card-label-row">
                            <span class="label-text">Stack Tecnológico</span>
                        </div>
                        <div class="tech-list">
                            @foreach($proyecto->softwares as $software)
                                <span class="tech-pill tech-tooltip" data-tip="{{ $software->descripcion ?? 'Herramienta utilizada' }}">
                                    {{ $software->nombre }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- 4. ENLACES --}}
                    @php
                        $drive = $proyecto->multimedia->where('tipo', 'drive')->first();
                        $github = $proyecto->multimedia->where('tipo', 'github')->first();
                    @endphp
                    @if($drive || $github)
                    <div class="links-grid">
                        @if($github)
                            <a href="{{ $github->url }}" target="_blank" class="link-btn link-github">
                                <svg class="link-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                <span class="link-text">Repositorio</span>
                            </a>
                        @endif
                        @if($drive)
                            <a href="{{ $drive->url }}" target="_blank" class="link-btn link-drive">
                                <svg class="link-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M12.01 1.485c2.082 0 3.754.02 3.743.047.01.02 1.708 2.981 3.784 6.57l.035.063H12.01L4.444 21.28c-.027.047-.04.047-.075.006-.046-.056-6.19-10.742-3.793-14.896C2.378 2.593 10.37 1.485 12.01 1.485zm4.88 7.036l-3.267 5.666h6.582c3.55 0 3.903-.047 3.738-.501-.354-.972-3.23-5.962-3.518-6.109-.165-.083-3.41-.097-3.535.944zm-7.667.625l3.256 5.66H5.85C2.26 14.806 1.95 14.842 2.126 15.297c.365.944 3.23 5.952 3.517 6.108.14.075 6.942.094 7.083.02 1.05-.555 3.197-4.27 4.774-8.257l2.874-7.26H9.223z"/></svg>
                                <span class="link-text">Documentación</span>
                            </a>
                        @endif
                    </div>
                    @endif
                </div>

                {{-- COLUMNA 2 (Derecha): INFO & DATOS --}}
                <div class="info-column">
                    
                    {{-- 1. HEADER & DESCRIPCIÓN --}}
                    <section class="info-card">
                        <div class="project-header">
                            <div>
                                <span class="label-text" style="display:block; margin-bottom:0.25rem;">Proyecto</span>
                                <h1 style="font-size:2rem;">
                                    {{ $proyecto->titulo ?? 'Sin título definido' }}
                                </h1>
                            </div>
                            
                            {{-- Badge --}}
                            <span class="status-badge
                                {{ $proyecto->estatus === 'aprobado' ? 'status-aprobado' : '' }}
                                {{ $proyecto->estatus === 'rechazado' ? 'status-rechazado' : '' }}
                                {{ $proyecto->estatus === 'borrador' ? 'status-borrador' : '' }}
                                {{ $proyecto->estatus === 'enviado' ? 'status-enviado' : '' }}">
                                {{ $proyecto->estatus == 'borrador' && !$proyecto->titulo ? 'Pendiente' : $proyecto->estatus }}
                            </span>
                        </div>
                        
                        <div>
                            <span class="label-text" style="display:block; margin-bottom:0.75rem;">Descripción</span>
                            <div class="prose-desc">
                                <p>{{ $proyecto->descripcion ?? 'Sin descripción disponible.' }}</p>
                            </div>
                        </div>
                    </section>

                    {{-- 2. BLOQUE UNIFICADO: EQUIPO & ACADÉMICO --}}
                    <section class="unified-card">
                        
                        {{-- A. Equipo --}}
                        <div class="section-header">
                            <h3 class="section-title">
                                <svg class="icon-sm" style="margin-right:0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                {{ $proyecto->autores->count() > 1 ? 'Equipo de Desarrollo' : 'Autor' }}
                            </h3>
                        </div>
                        
                        <div class="team-grid">
                            @foreach($proyecto->autores as $autor)
                                <div class="team-member {{ $autor->id == auth()->user()->estudiante->id ? 'is-me' : '' }}">
                                    <div class="avatar">
                                        {{ substr($autor->nombre, 0, 1) }}{{ substr($autor->apellido_paterno, 0, 1) }}
                                    </div>
                                    <div class="member-info">
                                        <div class="member-name-row">
                                            <span class="member-name">
                                                {{ $autor->nombre }} {{ $autor->apellido_paterno }}
                                            </span>
                                            @if($autor->pivot->es_lider)
                                                <span class="role-badge role-lider">Líder</span>
                                            @endif
                                        </div>
                                        <span class="member-matricula">{{ $autor->matricula }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- B. Académico --}}
                        <div class="academic-footer">
                            <div class="academic-grid">
                                <div class="academic-item">
                                    <span>Materia</span>
                                    <div class="academic-val">{{ $proyecto->materia->nombre }}</div>
                                </div>
                                <div class="academic-item">
                                    <span>Profesor</span>
                                    <div class="academic-val">{{ $proyecto->profesor->nombre }} {{ $proyecto->profesor->apellido_paterno }}</div>
                                </div>
                                <div class="academic-item">
                                    <span>Periodo</span>
                                    <span class="academic-val periodo-tag">{{ $proyecto->periodo_semestral }}</span>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>

            </div>

        </main>
    </div>
    
    @vite(['resources/js/components/sidebar.js'])
</body>
</html>