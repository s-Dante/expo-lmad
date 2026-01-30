<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto - Expo LMAD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto px-6 py-8">
        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
            
            <div class="bg-gray-800 px-6 py-4">
                <h2 class="text-xl font-bold text-white">
                    {{ $proyecto->titulo ? 'Editar Proyecto' : 'Registrar Proyecto' }}
                </h2>
                <p class="text-gray-400 text-sm">Materia: {{ $proyecto->materia->nombre }}</p>
            </div>

            <div class="p-8">
                {{-- Errores de validación --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4">
                        <p class="font-bold">Por favor corrige los siguientes errores:</p>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('estudiante.proyectos.update', $proyecto->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="titulo" class="block text-gray-700 font-bold mb-2">Título del Proyecto *</label>
                        <input type="text" name="titulo" id="titulo" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ old('titulo', $proyecto->titulo) }}" placeholder="Ej: Sistema de Gestión..." required>
                    </div>

                    <div class="mb-6">
                        <label for="descripcion" class="block text-gray-700 font-bold mb-2">Descripción del Proyecto *</label>
                        <textarea name="descripcion" id="descripcion" rows="5" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Describe de qué trata tu proyecto..." required>{{ old('descripcion', $proyecto->descripcion) }}</textarea>
                    </div>

                    <div class="mb-8">
                        <label class="block text-gray-700 font-bold mb-2">Póster o Portada (Imagen)</label>
                        
                        @if($proyecto->multimedia()->where('es_portada', true)->exists())
                            <div class="mb-2 p-2 bg-gray-100 rounded inline-block border border-gray-200">
                                <span class="text-xs text-green-600 font-bold">✓ Imagen actual cargada</span>
                            </div>
                        @endif

                        <input type="file" name="poster" id="poster" accept="image/*"
                               class="w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-blue-50 file:text-blue-700
                                      hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">Formatos permitidos: JPG, PNG. Máx: 5MB.</p>
                    </div>

                    <hr class="border-gray-200 mb-8">

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <label for="codigo_acceso" class="block text-gray-800 font-bold mb-2">🔑 Código de Seguridad (Token)</label>
                        <p class="text-sm text-gray-600 mb-3">
                            Para guardar los cambios, debes ingresar el código único que fue enviado a tu correo electrónico.
                        </p>
                        <input type="text" name="codigo_acceso" id="codigo_acceso" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 font-mono tracking-widest text-center uppercase"
                               placeholder="INGRESA EL TOKEN AQUÍ" required>
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('estudiante.proyectos.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-bold">Cancelar</a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold shadow-lg">
                            Guardar y Enviar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>