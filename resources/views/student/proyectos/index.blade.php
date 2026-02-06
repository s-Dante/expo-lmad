<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Proyectos - Expo LMAD</title>

    {{-- Carga de Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Estilos del Sidebar --}}
    @vite(['resources/css/components/sidebar.css'])

    <style>
        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Animación suave para el tooltip */
        .tooltip-content {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease-in-out, visibility 0.2s ease-in-out, transform 0.2s;
            transform: translateY(5px);
        }

        .group:hover .tooltip-content {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
    </style>
</head>

<body>

    {{-- Sidebar Component --}}
    <x-sidebar />

    {{--
        Contenido Principal 
        Jeje una disculpa por dejarlo en tailwind xd
    --}}
    <main class="flex-1 p-8 ml-0 md:ml-64 transition-all duration-300">

        {{-- Encabezado --}}
        <header class="flex flex-col md:flex-row justify-between items-center mb-8 border-b border-gray-300 pb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Proyectos a Exponer</h1>
                <p class="text-gray-500">Gestión de tus trabajos para la EXPO LMAD</p>
            </div>
        </header>

        {{-- Mensajes Flash --}}
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
            {{ session('error') }}
        </div>
        @endif

        {{--
            Grid de Proyectos 
            Todo lo que esta aqui abajo podria hacerse un componente y ya solamente mandar a 
            llamarlo pasandole la informacion para que se llene y separar esta logica y simplificar,
                Al final este es un ciclo for por lo que un componente quiza rediuzca la carga de codigo aqui
        --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @forelse($proyectos as $proyecto)
            <article class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-200 overflow-visible flex flex-col h-full relative z-0 hover:z-10">

                {{-- Cabecera con Materia y Estatus --}}
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center shrink-0">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Materia</span>
                        <h3 class="text-base font-bold text-gray-800">{{ $proyecto->materia->nombre }}</h3>
                    </div>

                    {{-- BADGE DE ESTATUS CON TOOLTIP --}}
                    <div class="group relative cursor-help">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase border inline-block
                                    {{ $proyecto->estatus === 'aprobado' ? 'bg-green-100 text-green-800 border-green-200' : '' }}
                                    {{ $proyecto->estatus === 'rechazado' ? 'bg-red-100 text-red-800 border-red-200' : '' }}
                                    {{ $proyecto->estatus === 'borrador' ? 'bg-gray-100 text-gray-800 border-gray-200' : '' }}
                                    {{ $proyecto->estatus === 'enviado' ? 'bg-yellow-100 text-yellow-800 border-yellow-200' : '' }}">
                            {{ $proyecto->estatus == 'borrador' && !$proyecto->titulo ? 'Pendiente' : $proyecto->estatus }}
                        </span>

                        {{-- Contenido del Tooltip --}}
                        <div class="tooltip-content absolute right-0 top-full mt-2 w-64 p-3 bg-gray-800 text-white text-xs rounded-lg shadow-xl z-50 text-center pointer-events-none">
                            @if($proyecto->estatus === 'rechazado')
                            <strong class="block text-red-300 mb-1 uppercase">Motivo de Rechazo:</strong>
                            <p class="italic">"{{ $proyecto->retroalimentacion }}"</p>
                            @elseif($proyecto->estatus === 'borrador')
                            <p>Tu proyecto está en modo edición. Solo tú y tu equipo pueden verlo.</p>
                            @elseif($proyecto->estatus === 'enviado')
                            <p>El proyecto está siendo revisado por el profesor. No puedes editarlo por ahora.</p>
                            @elseif($proyecto->estatus === 'aprobado')
                            <p>¡Felicidades! Tu proyecto ha sido aprobado para la Expo.</p>
                            @endif

                            {{-- Triángulo del tooltip --}}
                            <div class="absolute bottom-full right-4 -mb-1 border-4 border-transparent border-b-gray-800"></div>
                        </div>
                    </div>
                </div>

                {{-- Cuerpo de la Tarjeta --}}
                <div class="p-6 flex-1 flex flex-col">

                    {{-- Título y Descripción --}}
                    <div class="mb-6">
                        <h4 class="text-xl font-bold text-gray-900 mb-2 truncate" title="{{ $proyecto->titulo }}">
                            {{ $proyecto->titulo ?? 'Sin título asignado' }}
                        </h4>
                        <p class="text-sm text-gray-600 line-clamp-3 leading-relaxed h-[4.5rem]">
                            {{ $proyecto->descripcion ?? 'Aún no se ha registrado la información para este proyecto. Haz clic en el botón inferior para comenzar.' }}
                        </p>
                    </div>

                    {{-- Sección de Integrantes --}}
                    <div class="mb-6 flex-1">
                        @php
                        $esIndividual = $proyecto->autores->count() <= 1;
                            $tituloSeccion=$esIndividual ? '👤 Proyecto Individual' : '👥 Equipo de Trabajo' ;
                            @endphp

                            <div class="flex items-center mb-2">
                            <h5 class="text-xs font-bold uppercase tracking-wider {{ $esIndividual ? 'text-blue-600' : 'text-gray-500' }}">
                                {{ $tituloSeccion }}
                            </h5>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 max-h-24 overflow-y-auto custom-scroll">
                        @if(!$esIndividual)
                        <ul class="space-y-1">
                            @foreach($proyecto->autores as $autor)
                            <li class="flex justify-between items-center text-sm group">
                                <span class="text-gray-700 font-medium group-hover:text-gray-900 transition-colors {{ $autor->id == auth()->user()->estudiante->id ? 'text-blue-700' : '' }}">
                                    {{ $autor->nombre }} {{ $autor->apellido_paterno }}
                                </span>
                                <span class="font-mono text-[10px] text-gray-400 bg-white border border-gray-200 px-1.5 py-0.5 rounded">
                                    {{ $autor->matricula }}
                                </span>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <div class="text-sm text-gray-600 italic">
                            Este proyecto será desarrollado únicamente por ti.
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Profesor --}}
                <div class="text-xs text-gray-400 mb-6 shrink-0">
                    Asignado por: <span class="font-semibold text-gray-600">Prof. {{ $proyecto->profesor->nombre }} {{ $proyecto->profesor->apellido_paterno }}</span>
                </div>

                {{-- Botones de Acción (Footer) --}}
                <div class="mt-auto pt-4 border-t border-gray-100 shrink-0">
                    @if(in_array($proyecto->estatus, ['borrador', 'rechazado']))

                    @php
                    // Validar Liderazgo
                    $miParticipacion = $proyecto->autores->find(auth()->user()->estudiante->id);
                    $soyLider = $miParticipacion ? $miParticipacion->pivot->es_lider : false;
                    @endphp

                    @if($soyLider)
                    <a href="{{ route('estudiante.proyectos.edit', $proyecto->id) }}"
                        class="block w-full text-center py-2.5 px-4 rounded-lg font-bold shadow-sm transition transform hover:-translate-y-0.5
                                           {{ !$proyecto->titulo ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-white text-blue-600 border border-blue-200 hover:border-blue-400 hover:bg-blue-50' }}">
                        {{ !$proyecto->titulo ? '📝 Registrar Información' : '✏️ Editar Proyecto' }}
                    </a>
                    @else
                    <div class="group/btn relative w-full">
                        <button disabled class="block w-full text-center py-2.5 px-4 rounded-lg font-bold bg-gray-100 text-gray-400 border border-gray-200 cursor-not-allowed flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <span>Edición Restringida</span>
                        </button>

                        {{-- Tooltip Botón --}}
                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover/btn:block w-48 z-20">
                            <div class="bg-gray-800 text-white text-xs rounded py-2 px-3 text-center shadow-lg">
                                Solo el <strong>Líder del Equipo</strong> puede editar.
                                <div class="absolute top-100 left-1/2 -ml-1 border-4 border-gray-800 border-t-gray-800 border-x-transparent border-b-transparent"></div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @else
                    <a href="{{ route('estudiante.proyectos.show', $proyecto->id) }}"
                        class="block w-full text-center py-2.5 px-4 rounded-lg font-bold bg-gray-800 text-white hover:bg-gray-700 transition shadow-sm flex items-center justify-center gap-2">
                        <span>👁️ Ver Detalles del Proyecto</span>
                    </a>
                    @endif
                </div>

        </div>
        </article>

        {{--
            En caso de no tener proyectos no se muestra su informacion y en la parte de arriba ⬆️ 
            Terminaria el componente
        --}}
        @empty
        <div class="col-span-1 lg:col-span-2 text-center py-20 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
            <div class="mx-auto h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Sin proyectos asignados</h3>
            <p class="mt-1 text-sm text-gray-500">Aún no se te ha asignado ningún proyecto este semestre.</p>
        </div>
        @endforelse
        </div>

    </main>

    @vite(['resources/js/components/sidebar.js'])
</body>

</html>