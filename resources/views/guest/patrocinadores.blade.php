<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CL26-TEST</title>
    @vite('resources/css/guest/template.css')
    @vite('resources/css/guest/daysUntilExpo.css')
    @vite('resources/css/guest/patrocinadores.css')

    @vite([
    'resources/js/guest/daysUntilExpo.js',
    'resources/js/guest/showButtonMenu.js'
    ])
</head>

<body>
    <div class="bg-navbar d-none"></div>

    <header class="hero">

        <div class="header-cronograma">
            <div class="header-logo">
                <img class="header-logo" src="{{ asset('assets/guest/LOGOEXPO2.png') }}">
            </div>

            <x-guest.timer />
        </div>

        <x-guest.navbar />
    </header>

    <div class="body-container-expo-schedule">
        <img src="{{ asset('assets/guest/Cancha_v1.png') }}" class="header-expo-3" style="padding: 0" />

        <div class="container-gradient">
            <h1 class="title">NUESTRAS ESTRELLAS</h1>

            @php
            // Orden de tiers de mayor a menor
            $tierOrden = ['Titanium', 'Diamante', 'Oro', 'Plata', 'Bronce'];
            @endphp

            @foreach ($tierOrden as $tierNombre)
            @if (isset($porTier[$tierNombre]) && $porTier[$tierNombre]->isNotEmpty())
            <div class="tier-section tier-section--{{ strtolower($tierNombre) }}">
                <h2 class="tier-label tier-label--{{ strtolower($tierNombre) }} d-none">{{ $tierNombre }}</h2>
                <section class="container-sponsors container-sponsors--{{ strtolower($tierNombre) }}">
                    @foreach ($porTier[$tierNombre] as $patrocinador)
                    <div class="blum">
                        <div class="star">
                            @if ($patrocinador->logo_url)
                            <a href="{{ $patrocinador->website_url ?? '#' }}" target="_blank" rel="noopener">
                                <img
                                    src="{{ str_starts_with($patrocinador->logo_url, 'http') ? $patrocinador->logo_url : asset('storage/' . $patrocinador->logo_url) }}"
                                    alt="{{ $patrocinador->nombre }}"
                                    class="img-fluid sponsor sponsor--{{ strtolower($tierNombre) }}"
                                    title="{{ $patrocinador->nombre }}" />
                            </a>
                            @else
                            <div class="sponsor-placeholder sponsor--{{ strtolower($tierNombre) }}">
                                {{ $patrocinador->nombre }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </section>
            </div>
            @endif
            @endforeach

            {{-- Mensaje cuando no hay patrocinadores registrados aún --}}
            @if ($patrocinadores->isEmpty())
            <p class="no-sponsors-msg">Próximamente anunciaremos a nuestros patrocinadores.</p>
            @endif
        </div>
    </div>

</body>

</html>