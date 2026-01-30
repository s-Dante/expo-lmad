<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Proyectos - Expo LMAD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Mis Proyectos Asignados</h2>
            <a href="{{ route('estudiante.dashboard') }}" class="text-blue-600 hover:text-blue-800 underline">Volver al Dashboard</a>
        </div>

        {{-- Mensajes Flash --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse($proyectos as $proyecto)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="bg-gray-50 p-4 border-b border-gray-100 flex justify-between items-start">
                        <div>
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Materia</span>
                            <h3 class="text-lg font-bold text-gray-800">{{ $proyecto->materia->nombre }}</h3>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase border
                            {{ $proyecto->estatus === 'aprobado' ? 'bg-green-100 text-green-800 border-green-200' : '' }}
                            {{ $proyecto->estatus === 'rechazado' ? 'bg-red-100 text-red-800 border-red-200' : '' }}
                            {{ $proyecto->estatus === 'borrador' ? 'bg-gray-100 text-gray-800 border-gray-200' : '' }}
                            {{ $proyecto->estatus === 'enviado' ? 'bg-yellow-100 text-yellow-800 border-yellow-200' : '' }}">
                            {{ $proyecto->estatus }}
                        </span>
                    </div>

                    <div class="p-6">
                        <p class="text-gray-600 mb-4">
                            <span class="font-bold">Título:</span> 
                            {{ $proyecto->titulo ?? 'Pendiente de asignar...' }}
                        </p>
                        
                        <p class="text-sm text-gray-500 mb-4">
                            {{ $proyecto->descripcion ?? 'Sin descripción disponible.' }}
                        </p>

                        @if($proyecto->estatus === 'rechazado' && $proyecto->retroalimentacion)
                            <div class="bg-red-50 p-3 rounded-lg mb-4 border border-red-200">
                                <p class="text-xs font-bold text-red-600 uppercase mb-1">Motivo de corrección:</p>
                                <p class="text-sm text-red-700">{{ $proyecto->retroalimentacion }}</p>
                            </div>
                        @endif

                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                Prof. {{ $proyecto->profesor->nombre }} {{ $proyecto->profesor->apellido_paterno }}
                            </div>

                            @if(in_array($proyecto->estatus, ['borrador', 'rechazado']))
                                <a href="{{ route('estudiante.proyectos.edit', $proyecto->id) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
                                    {{ $proyecto->titulo ? 'Editar Proyecto' : 'Registrar Información' }}
                                </a>
                            @else
                                <button disabled class="bg-gray-300 text-gray-500 font-bold py-2 px-4 rounded cursor-not-allowed">
                                    En Revisión
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-12 bg-white rounded-lg shadow">
                    <p class="text-gray-500 text-lg">No tienes proyectos asignados actualmente.</p>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>