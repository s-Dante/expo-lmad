<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Estudiante - Expo LMAD</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    @vite(['resources/css/components/sidebar.css'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">

    <div class="flex min-h-screen">
        
        <x-sidebar />

        <main class="flex-1 p-8 ml-0 md:ml-64 transition-all duration-300">
            
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-gray-200 pb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Panel de Control</h1>
                    <p class="text-gray-500 mt-1 text-sm">Bienvenid@ a la plataforma Expo LMAD</p>
                </div>
                
                <div class="mt-4 md:mt-0 text-right">
                    <span class="block font-bold text-gray-800 text-lg leading-tight">
                        {{ auth()->user()->nombre }} {{ auth()->user()->apellido_paterno }} {{ auth()->user()->apellido_materno }}
                    </span>
                    <div class="flex items-center justify-end gap-2 text-xs uppercase tracking-widest mt-1">
                        <span class="text-gray-400 font-medium">Estudiante</span>
                        <span class="text-gray-300">|</span>
                        <span class="text-gray-500 font-mono">{{ auth()->user()->estudiante->matricula ?? 'S/M' }}</span>
                    </div>
                </div>
            </header>

            <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between hover:border-blue-200 transition h-32">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Proyectos Asignados</p>
                    <div class="flex items-end justify-between">
                        <p class="text-4xl font-extrabold text-gray-900">{{ isset($conteoProyectos) ? $conteoProyectos : 0 }}</p>
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between hover:border-yellow-200 transition h-32">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">En Revisión / Pendiente</p>
                    <div class="flex items-end justify-between">
                        <p class="text-4xl font-extrabold text-gray-900">{{ isset($conteoPendientes) ? $conteoPendientes : 0 }}</p>
                        <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between hover:border-green-200 transition h-32">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Proyectos Aprobados</p>
                    <div class="flex items-end justify-between">
                        <p class="text-4xl font-extrabold text-gray-900">{{ isset($conteoAprobados) ? $conteoAprobados : 0 }}</p>
                        <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

            </section>

            <section class="bg-blue-50/50 border border-blue-100 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-sm font-bold text-blue-800 uppercase tracking-wide">Información Relevante</h3>
                </div>
                
                <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex items-start">
                        <span class="mr-2">•</span>
                        <span>
                            Tu <strong>Código QR</strong> es necesario para registrar asistencia el día del evento.
                        </span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">•</span>
                        <span>
                            Si tu proyecto es rechazado, deberás corregir las observaciones indicadas por tu profesor para ser aprobado nuevamente.
                        </span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">•</span>
                        <span>
                            El póster del proyecto debe estar en formato cuadrado (1:1) para su correcta visualización en la galería.
                        </span>
                    </li>
                </ul>
            </section>

        </main>
    </div>

    @vite(['resources/js/components/sidebar.js'])
</body>
</html>