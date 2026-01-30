<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi QR - Expo LMAD</title>
    
    {{-- Carga de Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Estilos del Sidebar --}}
    @vite(['resources/css/components/sidebar.css'])
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">

    <div class="flex min-h-screen">
        
        {{-- Sidebar Component --}}
        <x-sidebar />

        {{-- Contenido Principal --}}
        <main class="flex-1 p-4 ml-0 md:ml-64 transition-all duration-300 min-h-screen flex flex-col items-center justify-center">
            
            <article class="bg-white p-8 rounded-xl shadow-lg text-center max-w-md w-full border border-gray-200 relative overflow-hidden">
                
                {{-- Lógica de UI basada en la nueva tabla de asistencia --}}
                @if($asistio)
                    <div class="absolute top-0 left-0 w-full bg-green-500 text-white text-xs font-bold py-2 uppercase tracking-widest">
                        ✅ Asistencia Registrada
                    </div>
                @else
                    <div class="absolute top-0 left-0 w-full bg-gray-200 text-gray-500 text-xs font-bold py-2 uppercase tracking-widest">
                        ⏳ Pendiente de Registro
                    </div>
                @endif

                <header class="mt-6 mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">Pase de Acceso</h1>
                    <p class="text-gray-500 font-medium">Expo LMAD 2026</p>
                </header>

                {{-- QR con Logo superpuesto --}}
                <figure class="relative bg-white p-4 rounded-lg mb-6 inline-block border-2 border-gray-100">
                    
                    {{-- QR Code (High Error Correction 'ecc=H' permite tapar el centro) --}}
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&ecc=H&data={{ $estudiante->matricula }}" 
                         alt="QR Acceso" 
                         class="w-64 h-64 mix-blend-multiply opacity-90">

                    {{-- Logo centrado --}}
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-1 rounded-full shadow-sm">
                        <img src="{{ asset('assets/guest/LOGOEXPO2.png') }}" 
                             alt="Logo" 
                             class="w-12 h-12 object-contain">
                    </div>
                </figure>

                {{-- Datos del Estudiante (Del Padrón) --}}
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-800 uppercase">{{ $estudiante->nombre }}</h2>
                    <h3 class="text-lg text-gray-700">{{ $estudiante->apellido_paterno }} {{ $estudiante->apellido_materno }}</h3>
                    <div class="mt-2 inline-block bg-blue-50 text-blue-800 px-3 py-1 rounded-full text-sm font-mono font-bold tracking-wider border border-blue-100">
                        {{ $estudiante->matricula }}
                    </div>
                </div>

                {{-- Feedback Visual --}}
                @if($asistio)
                    <div class="bg-green-50 text-green-800 text-sm p-4 rounded-lg border border-green-200">
                        <p class="font-bold text-lg">¡Bienvenido!</p>
                        <p>Tu entrada ha sido validada correctamente.</p>
                        <p class="text-xs mt-2 text-green-600">Disfruta el evento.</p>
                    </div>
                @else
                    <div class="bg-blue-50 text-blue-800 text-sm p-4 rounded-lg border border-blue-100">
                        <p class="font-bold mb-1">Instrucciones:</p>
                        <p>Presenta este código al Staff en la entrada del auditorio para registrar tu asistencia.</p>
                    </div>
                @endif

            </article>

            <footer class="mt-8 text-gray-400 text-xs text-center">
                Generado por Sistema Expo LMAD<br>
                {{ date('d/m/Y') }}
            </footer>

        </main>
    </div>
    
    @vite(['resources/js/components/sidebar.js'])
</body>
</html>