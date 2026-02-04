<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Proyecto - {{ $proyecto->titulo }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/components/sidebar.css'])

    <style>
        .tech-tooltip { position: relative; cursor: help; }
        .tech-tooltip:hover::after {
            content: attr(data-tip);
            position: absolute; bottom: 125%; left: 50%; transform: translateX(-50%);
            background: #1f2937; color: #fff; padding: 6px 10px; border-radius: 6px;
            font-size: 0.75rem; white-space: nowrap; z-index: 50;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); pointer-events: none;
        }
        .tech-tooltip:hover::before {
            content: ''; position: absolute; bottom: 115%; left: 50%; margin-left: -5px;
            border-width: 5px; border-style: solid; border-color: #1f2937 transparent transparent transparent; z-index: 50;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">

    <div class="flex min-h-screen">
        
        <x-sidebar />

        <main class="flex-1 p-8 ml-0 md:ml-64 transition-all duration-300">
            
            {{-- Navegación --}}
            <nav class="flex justify-between items-center mb-8">
                <a href="{{ route('estudiante.proyectos.index') }}" class="flex items-center text-gray-500 hover:text-blue-600 transition group">
                    <span class="bg-white border border-gray-200 rounded-full p-2 mr-2 group-hover:border-blue-200 group-hover:bg-blue-50 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </span>
                    <span class="font-medium text-sm">Volver al listado</span>
                </a>

                {{-- Edición (Si aplica, botón flotante aquí arriba también) --}}
                @if(in_array($proyecto->estatus, ['borrador', 'rechazado']))
                    @php
                        $miParticipacion = $proyecto->autores->find(auth()->user()->estudiante->id);
                        $soyLider = $miParticipacion ? $miParticipacion->pivot->es_lider : false;
                    @endphp
                    @if($soyLider)
                        <a href="{{ route('estudiante.proyectos.edit', $proyecto->id) }}" class="text-sm font-bold text-blue-600 hover:underline flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Editar Información
                        </a>
                    @endif
                @endif
            </nav>

            {{-- Alerta Retroalimentación --}}
            @if($proyecto->estatus === 'rechazado' && $proyecto->retroalimentacion)
                <div class="bg-red-50 border-l-4 border-red-500 p-6 mb-8 rounded-r-xl shadow-sm flex items-start animate-pulse-slow">
                    <svg class="w-6 h-6 text-red-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        <h3 class="text-sm font-bold text-red-800 uppercase tracking-wide">Correcciones Requeridas</h3>
                        <p class="text-red-700 text-sm mt-1">"{{ $proyecto->retroalimentacion }}"</p>
                    </div>
                </div>
            @endif

            {{-- Layout Principal: Izquierda (Info) 7 cols / Derecha (Media) 5 cols --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                {{-- === COLUMNA 1 (Izquierda): NARRATIVA & DATOS (Contexto) === --}}
                <div class="lg:col-span-7 space-y-8">
                    
                    {{-- 1. HEADER & DESCRIPCIÓN --}}
                    <section class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
                        {{-- Header Flexible --}}
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 border-b border-gray-100 pb-6">
                            <div>
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Proyecto</span>
                                <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">
                                    {{ $proyecto->titulo ?? 'Sin título definido' }}
                                </h1>
                            </div>
                            
                            {{-- Badge Grande --}}
                            <div class="flex-shrink-0">
                                <span class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest border
                                    {{ $proyecto->estatus === 'aprobado' ? 'bg-green-50 text-green-700 border-green-200' : '' }}
                                    {{ $proyecto->estatus === 'rechazado' ? 'bg-red-50 text-red-700 border-red-200' : '' }}
                                    {{ $proyecto->estatus === 'borrador' ? 'bg-gray-50 text-gray-600 border-gray-200' : '' }}
                                    {{ $proyecto->estatus === 'enviado' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : '' }}">
                                    {{ $proyecto->estatus == 'borrador' && !$proyecto->titulo ? 'Pendiente' : $proyecto->estatus }}
                                </span>
                            </div>
                        </div>
                        
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-3">Descripción</span>
                            <div class="prose max-w-none text-gray-600 leading-relaxed text-lg">
                                <p class="whitespace-pre-line">
                                    {{ $proyecto->descripcion ?? 'Sin descripción disponible.' }}
                                </p>
                            </div>
                        </div>
                    </section>

                    {{-- 2. BLOQUE UNIFICADO: EQUIPO & ACADÉMICO --}}
                    <section class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        
                        {{-- A. Equipo --}}
                        <div class="p-6">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                {{ $proyecto->autores->count() > 1 ? 'Equipo de Desarrollo' : 'Autor' }}
                            </span>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($proyecto->autores as $autor)
                                    <div class="flex items-center p-3 rounded-xl border {{ $autor->id == auth()->user()->estudiante->id ? 'bg-blue-50 border-blue-100' : 'bg-gray-50 border-gray-100' }}">
                                        {{-- Avatar Placeholder --}}
                                        <div class="h-10 w-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-xs font-bold text-gray-500 mr-3 shadow-sm">
                                            {{ substr($autor->nombre, 0, 1) }}{{ substr($autor->apellido_paterno, 0, 1) }}
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-bold text-gray-800">
                                                    {{ $autor->nombre }} {{ $autor->apellido_paterno }}
                                                </span>
                                                @if($autor->pivot->es_lider)
                                                    <span class="text-[10px] bg-yellow-100 text-yellow-800 px-1.5 py-0.5 rounded uppercase font-bold tracking-wider">Líder</span>
                                                @endif
                                            </div>
                                            <span class="text-xs text-gray-500 font-mono block">{{ $autor->matricula }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Separador --}}
                        <div class="h-px bg-gray-100 mx-6"></div>

                        {{-- B. Académico --}}
                        <div class="p-6 bg-gray-50/50">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                Contexto Académico
                            </span>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <span class="block text-[10px] text-gray-400 uppercase mb-1">Materia</span>
                                    <span class="font-bold text-gray-800 text-sm">{{ $proyecto->materia->nombre }}</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] text-gray-400 uppercase mb-1">Profesor</span>
                                    <span class="font-bold text-gray-800 text-sm">{{ $proyecto->profesor->nombre }} {{ $proyecto->profesor->apellido_paterno }}</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] text-gray-400 uppercase mb-1">Periodo</span>
                                    <span class="inline-block bg-white border border-gray-200 px-2 py-1 rounded text-xs font-mono text-gray-600">{{ $proyecto->periodo_semestral }}</span>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
                
                {{-- === COLUMNA 2 (Derecha): MULTIMEDIA & TECH (Agrupados) === --}}
                <div class="lg:col-span-5 space-y-6">
                    
                    {{-- 1. PÓSTER (Grande y Prominente) --}}
                    <div class="bg-white p-2 rounded-2xl shadow-sm border border-gray-200">
                        @php $portada = $proyecto->multimedia->where('es_portada', true)->first(); @endphp
                        
                        @if($portada)
                            <div class="relative w-full aspect-square bg-gray-100 rounded-xl overflow-hidden group shadow-inner">
                                <img src="{{ asset('storage/' . $portada->url) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                                <a href="{{ asset('storage/' . $portada->url) }}" target="_blank" class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center backdrop-blur-[2px]">
                                    <span class="bg-white text-gray-900 px-4 py-2 rounded-full font-bold text-sm shadow-lg transform translate-y-2 group-hover:translate-y-0 transition flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Ver Completo
                                    </span>
                                </a>
                            </div>
                        @else
                            <div class="w-full aspect-square bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-16 h-16 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-sm font-medium">Sin póster cargado</span>
                            </div>
                        @endif
                    </div>

                    {{-- 2. VIDEO (Debajo del póster, misma jerarquía) --}}
                    @php $video = $proyecto->multimedia->where('tipo', 'youtube')->first(); @endphp
                    @if($video)
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Video Demo</span>
                            <span class="bg-red-50 text-red-600 text-[10px] px-2 py-0.5 rounded font-bold uppercase">YouTube</span>
                        </div>
                        <div class="w-full aspect-video rounded-xl overflow-hidden bg-black shadow-inner">
                            <iframe class="w-full h-full" src="{{ $video->url }}" title="Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    @endif

                    {{-- 3. STACK TECNOLÓGICO (Visual) --}}
                    @if($proyecto->softwares->count() > 0)
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-3">Stack Tecnológico</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach($proyecto->softwares as $software)
                                <span class="tech-tooltip inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold bg-slate-50 text-slate-700 border border-slate-200 hover:bg-blue-50 hover:text-blue-700 hover:border-blue-200 transition cursor-help select-none shadow-sm" 
                                      data-tip="{{ $software->descripcion ?? 'Herramienta utilizada' }}">
                                    {{ $software->nombre }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- 4. ENLACES (Resources) --}}
                    @php
                        $drive = $proyecto->multimedia->where('tipo', 'drive')->first();
                        $github = $proyecto->multimedia->where('tipo', 'github')->first();
                    @endphp
                    @if($drive || $github)
                    <div class="grid grid-cols-2 gap-3">
                        @if($github)
                            <a href="{{ $github->url }}" target="_blank" class="flex flex-col items-center justify-center p-4 bg-gray-900 text-white rounded-xl hover:bg-gray-800 transition shadow-sm group text-center">
                                <svg class="w-6 h-6 mb-2 opacity-70 group-hover:opacity-100 transition" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                <span class="font-bold text-sm">Repositorio</span>
                            </a>
                        @endif
                        @if($drive)
                            <a href="{{ $drive->url }}" target="_blank" class="flex flex-col items-center justify-center p-4 bg-white text-blue-700 border border-blue-100 rounded-xl hover:border-blue-300 hover:shadow-md transition group text-center">
                                <svg class="w-6 h-6 mb-2 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12.01 1.485c2.082 0 3.754.02 3.743.047.01.02 1.708 2.981 3.784 6.57l.035.063H12.01L4.444 21.28c-.027.047-.04.047-.075.006-.046-.056-6.19-10.742-3.793-14.896C2.378 2.593 10.37 1.485 12.01 1.485zm4.88 7.036l-3.267 5.666h6.582c3.55 0 3.903-.047 3.738-.501-.354-.972-3.23-5.962-3.518-6.109-.165-.083-3.41-.097-3.535.944zm-7.667.625l3.256 5.66H5.85C2.26 14.806 1.95 14.842 2.126 15.297c.365.944 3.23 5.952 3.517 6.108.14.075 6.942.094 7.083.02 1.05-.555 3.197-4.27 4.774-8.257l2.874-7.26H9.223z"/></svg>
                                <span class="font-bold text-sm">Documentación</span>
                            </a>
                        @endif
                    </div>
                    @endif
                </div>

            </div>

        </main>
    </div>
    
    @vite(['resources/js/components/sidebar.js'])
</body>
</html>