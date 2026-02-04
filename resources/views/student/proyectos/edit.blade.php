<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $proyecto->titulo ? 'Editar Proyecto' : 'Registro de Proyecto' }} - Expo LMAD</title>
    
    {{-- Carga de Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Estilos del Sidebar --}}
    @vite(['resources/css/components/sidebar.css'])

    <style>
        /* Estilos para tooltips simples con CSS puro */
        .tooltip { position: relative; display: inline-block; cursor: help; }
        .tooltip .tooltip-text {
            visibility: hidden; width: 220px; background-color: #333; color: #fff;
            text-align: center; border-radius: 6px; padding: 8px; position: absolute;
            z-index: 10; bottom: 125%; left: 50%; margin-left: -110px;
            opacity: 0; transition: opacity 0.3s; font-size: 0.75rem; font-weight: normal;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); pointer-events: none;
        }
        .tooltip .tooltip-text::after {
            content: ""; position: absolute; top: 100%; left: 50%; margin-left: -5px;
            border-width: 5px; border-style: solid; border-color: #333 transparent transparent transparent;
        }
        .tooltip:hover .tooltip-text { visibility: visible; opacity: 1; }

        /* Animación suave para badges */
        .badge-enter { animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        @keyframes popIn { from { transform: scale(0.5); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">

    <div class="flex min-h-screen">
        
        {{-- Sidebar --}}
        <x-sidebar />

        <main class="flex-1 p-8 ml-0 md:ml-64 transition-all duration-300">
            <div class="max-w-5xl mx-auto">
                
                {{-- Breadcrumbs --}}
                <nav class="flex mb-6 text-sm text-gray-500" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('estudiante.dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                        </li>
                        <li><span class="mx-2">/</span></li>
                        <li class="inline-flex items-center">
                            <a href="{{ route('estudiante.proyectos.index') }}" class="hover:text-blue-600 transition">Mis Proyectos</a>
                        </li>
                        <li><span class="mx-2">/</span></li>
                        <li aria-current="page">
                            <span class="font-semibold text-gray-700">{{ $proyecto->titulo ? 'Editar' : 'Registrar' }}</span>
                        </li>
                    </ol>
                </nav>

                {{-- ALERTA DE RECHAZO (Retroalimentación) --}}
                @if($proyecto->estatus === 'rechazado' && $proyecto->retroalimentacion)
                    <div class="bg-red-50 border-l-4 border-red-500 p-6 mb-8 rounded-lg shadow-sm animate-pulse-slow">
                        <div class="flex">
                            <div class="shrink-0">
                                <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-red-800">Correcciones Necesarias</h3>
                                <p class="text-red-700 mt-1">{{ $proyecto->retroalimentacion }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Encabezado --}}
                <div class="mb-8 flex justify-between items-end">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                            {{ $proyecto->titulo ? 'Editar Información del Proyecto' : 'Registro de Nuevo Proyecto' }}
                        </h1>
                        <p class="text-gray-500 mt-2">Completa todos los campos requeridos para la evaluación de tu proyecto.</p>
                    </div>
                </div>

                {{-- Manejo de Errores General --}}
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded shadow-sm">
                        <p class="font-bold">Se encontraron errores en el formulario:</p>
                        <ul class="list-disc list-inside text-sm mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORMULARIO --}}
                <form action="{{ route('estudiante.proyectos.update', $proyecto->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8" id="projectForm">
                    @csrf
                    @method('PUT')

                    {{-- 1. INFORMACIÓN GENERAL --}}
                    <section class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex items-center mb-6 border-b border-gray-100 pb-2">
                            <h2 class="text-xl font-bold text-gray-800">1. Información General</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-6">
                            {{-- Título --}}
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                    Título del Proyecto <span class="text-red-500 ml-1">*</span>
                                    <div class="tooltip ml-2 text-gray-400 hover:text-blue-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="tooltip-text">El nombre oficial de tu proyecto. Debe ser corto, descriptivo y atractivo. Evita nombres genéricos como "Proyecto Final".</span>
                                    </div>
                                </label>
                                <input type="text" name="titulo" value="{{ old('titulo', $proyecto->titulo) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm bg-gray-50 focus:bg-white" 
                                       placeholder="Ej: Sistema de Gestión de Residuos con IA" required>
                            </div>

                            {{-- Descripción --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                    Descripción Detallada <span class="text-red-500 ml-1">*</span>
                                    <div class="tooltip ml-2 text-gray-400 hover:text-blue-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="tooltip-text">Explica qué hace tu proyecto, qué problema resuelve y cuáles son sus funciones principales. Mínimo 20 caracteres.</span>
                                    </div>
                                </label>
                                <textarea name="descripcion" rows="6" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm bg-gray-50 focus:bg-white resize-y" 
                                          placeholder="Describe el objetivo y funcionalidad..." required>{{ old('descripcion', $proyecto->descripcion) }}</textarea>
                            </div>
                        </div>
                    </section>

                    {{-- 2. MULTIMEDIA --}}
                    <section class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex items-center mb-6 border-b border-gray-100 pb-2">
                            <h2 class="text-xl font-bold text-gray-800">2. Multimedia y Enlaces</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                            
                            {{-- Columna Izquierda: Imagen (4 cols) --}}
                            <div class="md:col-span-4 flex flex-col items-center">
                                <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center self-start">
                                    Portada del Proyecto <span class="text-red-500 ml-1">*</span>
                                    <div class="tooltip ml-2 text-gray-400 hover:text-blue-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="tooltip-text">Imagen cuadrada (1:1) de alta calidad. Será la cara de tu proyecto en la galería. Formatos: JPG, PNG.</span>
                                    </div>
                                </label>

                                {{-- Área de Preview --}}
                                @php
                                    $portada = $proyecto->multimedia->where('es_portada', true)->first();
                                    $defaultImg = 'https://via.placeholder.com/300x300?text=Subir+Imagen';
                                    $currentImg = $portada ? asset('storage/' . $portada->url) : $defaultImg;
                                @endphp
                                
                                <div class="relative w-full aspect-square bg-gray-100 rounded-xl border-2 border-dashed border-gray-300 overflow-hidden hover:border-blue-400 transition group cursor-pointer" onclick="document.getElementById('posterInput').click()">
                                    <img id="previewImage" src="{{ $currentImg }}" class="w-full h-full object-cover">
                                    
                                    {{-- Overlay Hover --}}
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                        <span class="text-white font-bold text-sm bg-black/50 px-3 py-1 rounded">Cambiar Imagen</span>
                                    </div>
                                </div>

                                {{-- Input Oculto --}}
                                <input type="file" name="poster" id="posterInput" accept="image/*" class="hidden" onchange="previewFile(this)">
                                
                                <button type="button" onclick="document.getElementById('posterInput').click()" 
                                        class="mt-4 w-full py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-lg border border-gray-300 transition flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Seleccionar Archivo
                                </button>
                                <p class="text-xs text-gray-400 mt-2 text-center">Máx 5MB (JPG/PNG)</p>
                            </div>

                            {{-- Columna Derecha: Enlaces (8 cols) --}}
                            <div class="md:col-span-8 space-y-6">
                                
                                {{-- YouTube --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        Video Demo (YouTube) <span class="text-red-500 ml-1">*</span>
                                        <div class="tooltip ml-2 text-gray-400 hover:text-blue-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span class="tooltip-text">Pega el link completo de tu video en YouTube. El sistema lo convertirá para que se vea en la página.</span>
                                        </div>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-red-500">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                        </span>
                                        @php $youtube = $proyecto->multimedia->where('tipo', 'youtube')->first(); @endphp
                                        <input type="url" name="link_youtube" value="{{ old('link_youtube', $youtube?->url) }}" 
                                               class="w-full pl-10 px-4 py-3 border border-red-200 bg-red-50 rounded-lg focus:ring-2 focus:ring-red-500 focus:bg-white transition text-gray-700"
                                               placeholder="https://www.youtube.com/watch?v=..." required>
                                    </div>
                                </div>

                                {{-- Drive --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Google Drive (Documentación)</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-500">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.01 1.485c2.082 0 3.754.02 3.743.047.01.02 1.708 2.981 3.784 6.57l.035.063H12.01L4.444 21.28c-.027.047-.04.047-.075.006-.046-.056-6.19-10.742-3.793-14.896C2.378 2.593 10.37 1.485 12.01 1.485z"/></svg>
                                        </span>
                                        @php $drive = $proyecto->multimedia->where('tipo', 'drive')->first(); @endphp
                                        <input type="url" name="link_drive" value="{{ old('link_drive', $drive?->url) }}" 
                                               class="w-full pl-10 px-4 py-3 border border-blue-200 bg-blue-50 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white transition text-gray-700"
                                               placeholder="Enlace a carpeta de Drive (Opcional)">
                                    </div>
                                </div>

                                {{-- GitHub --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">GitHub (Código Fuente)</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416 0 0-1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                        </span>
                                        @php $github = $proyecto->multimedia->where('tipo', 'github')->first(); @endphp
                                        <input type="url" name="link_github" value="{{ old('link_github', $github?->url) }}" 
                                               class="w-full pl-10 px-4 py-3 border border-gray-300 bg-gray-50 rounded-lg focus:ring-2 focus:ring-gray-500 focus:bg-white transition text-gray-700"
                                               placeholder="Enlace al repositorio (Opcional)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- 3. TECNOLOGÍAS (Badges Interactivos) --}}
                    <section class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex items-center mb-6 border-b border-gray-100 pb-2">
                            <h2 class="text-xl font-bold text-gray-800">3. Stack Tecnológico</h2>
                            <div class="tooltip ml-2 text-gray-400 hover:text-blue-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="tooltip-text">Busca y selecciona las herramientas que usaste. Ej: Laravel, Python, Unity, Photoshop...</span>
                            </div>
                        </div>

                        {{-- Buscador y Filtro JS --}}
                        <div class="mb-4">
                            <input type="text" id="techSearch" placeholder="🔍 Buscar tecnología (Ej: Java, Figma...)" 
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none mb-4">
                            
                            {{-- Contenedor de Checkboxes (Visualmente Badges) --}}
                            <div class="flex flex-wrap gap-2 max-h-60 overflow-y-auto p-2 border border-gray-100 rounded-lg bg-gray-50 custom-scroll" id="techContainer">
                                @foreach($softwares as $software)
                                    @php
                                        $isChecked = in_array($software->id, old('softwares', $proyecto->softwares->pluck('id')->toArray()));
                                    @endphp
                                    <label class="cursor-pointer group tech-item" data-name="{{ strtolower($software->nombre) }}">
                                        <input type="checkbox" name="softwares[]" value="{{ $software->id }}" class="hidden peer" {{ $isChecked ? 'checked' : '' }}>
                                        <span class="inline-block px-3 py-1.5 rounded-full text-sm font-medium border transition select-none
                                              peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-700 peer-checked:shadow-md
                                              bg-white text-gray-600 border-gray-300 hover:border-blue-400 hover:text-blue-500">
                                            {{ $software->nombre }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-400 mt-2">Si no encuentras una tecnología, contacta a tu profesor para agregarla.</p>
                        </div>
                    </section>

                    {{-- 4. CONFIRMACIÓN Y ENVÍO --}}
                    <section class="bg-yellow-50 border border-yellow-200 rounded-xl p-8">
                        <div class="flex flex-col md:flex-row gap-8">
                            
                            {{-- Token --}}
                            <div class="flex-1">
                                <label class="block text-gray-800 font-bold mb-2 flex items-center">
                                    🔑 Token de Seguridad
                                    <div class="tooltip ml-2 text-yellow-600 hover:text-yellow-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        <span class="tooltip-text">El código único que recibiste por correo. Es necesario para validar que eres el líder del equipo.</span>
                                    </div>
                                </label>
                                <input type="text" name="codigo_acceso" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 font-mono tracking-widest uppercase bg-white text-lg"
                                       placeholder="CÓDIGO-123" required>
                            </div>

                            {{-- Check Enviar --}}
                            <div class="flex-1 flex flex-col justify-center">
                                <div class="flex items-center p-4 bg-white rounded-lg border border-yellow-100 shadow-sm hover:shadow-md transition cursor-pointer" onclick="document.getElementById('enviar_revision').click()">
                                    <input type="checkbox" id="enviar_revision" name="enviar_revision" value="1" 
                                           class="w-6 h-6 text-green-600 rounded focus:ring-green-500 cursor-pointer">
                                    <div class="ml-3 select-none">
                                        <label for="enviar_revision" class="font-bold text-gray-800 cursor-pointer block">
                                            Finalizar y Enviar a Revisión
                                        </label>
                                        <span class="text-xs text-gray-500 block mt-1">
                                            Si marcas esto, el proyecto se bloqueará para revisión. Si no, se guardará como <strong>Borrador</strong>.
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Botones Finales --}}
                    <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('estudiante.proyectos.index') }}" class="px-6 py-3 bg-white text-gray-700 font-bold rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                            Cancelar
                        </a>
                        <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-lg shadow-lg hover:bg-blue-700 hover:scale-105 transition transform flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Guardar Cambios
                        </button>
                    </div>

                </form>
            </div>
        </main>
    </div>
    
    @vite(['resources/js/components/sidebar.js'])

    {{-- SCRIPTS JS PUROS (Vanilla) --}}
    <script>
        // 1. Previsualización de Imagen
        function previewFile(input) {
            const preview = document.getElementById('previewImage');
            const file = input.files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        // 2. Filtro de Tecnologías (Buscador)
        document.getElementById('techSearch').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const items = document.querySelectorAll('.tech-item');

            items.forEach(item => {
                const name = item.getAttribute('data-name');
                if (name.includes(searchText)) {
                    item.style.display = 'inline-block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>