<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Estudiante - Expo LMAD</title>
    
    {{-- Carga de Tailwind (para estructura básica) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Estilos del Sidebar --}}
    @vite(['resources/css/components/sidebar.css'])
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- 
        CONTENEDOR PRINCIPAL 
    --}}
    <div class="flex min-h-screen">
        
        {{-- 1. SECCIÓN: SIDEBAR (Navegación) --}}
        <x-sidebar />

        {{-- 
            2. SECCIÓN: CONTENIDO PRINCIPAL 
        --}}
        <main class="flex-1 p-8 ml-0 md:ml-32 transition-all duration-300">
            
            {{-- 2.1 ENCABEZADO DEL DASHBOARD --}}
            <header class="flex justify-between items-center mb-8 border-b border-gray-300 pb-4">
                <h1 class="text-2xl font-bold">Panel de Control</h1>
                <div class="text-sm">
                    Usuario: <strong>{{ auth()->user()->nombre }} {{ auth()->user()->apellido_paterno }}</strong>
                </div>
            </header>

            {{-- 2.3 RESUMEN / BIENVENIDA --}}
            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-2">Bienvenido a la Expo LMAD</h2>
            </section>

            {{-- 2.4 TARJETAS DE ESTADÍSTICAS --}}
            <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                
                <article class="p-6 border border-gray-200 bg-white">
                    <h3 class="text-sm uppercase text-gray-500 font-bold">Proyectos Asignados</h3>
                    <p class="text-4xl mt-2 font-bold">{{ isset($conteoProyectos) ? $conteoProyectos : 0 }}</p>
                </article>

                <article class="p-6 border border-gray-200 bg-white">
                    <h3 class="text-sm uppercase text-gray-500 font-bold">En Revisión / Borrador</h3>
                    <p class="text-4xl mt-2 font-bold text-yellow-600">{{ isset($conteoPendientes) ? $conteoPendientes : 0 }}</p>
                </article>

                <article class="p-6 border border-gray-200 bg-white">
                    <h3 class="text-sm uppercase text-gray-500 font-bold">Aprobados</h3>
                    <p class="text-4xl mt-2 font-bold text-green-600">{{ isset($conteoAprobados) ? $conteoAprobados : 0 }}</p>
                </article>

            </section>

            {{-- 2.5 SECCIÓN DE AVISOS --}}
            <section class="border-t border-gray-300 pt-6">
                <h3 class="font-bold text-lg mb-4">Avisos Importantes</h3>
                <ul class="list-disc list-inside space-y-2">
                    <li>El código QR de asistencia es personal.</li>
                    <li>Revisa el estatus de tu proyecto periódicamente.</li>
                </ul>
            </section>

        </main>
    </div>

    {{-- Scripts necesarios para el sidebar --}}
    @vite(['resources/js/components/sidebar.js'])
</body>
</html>