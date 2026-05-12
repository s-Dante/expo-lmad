<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CL26-TEST</title>
    @vite('resources/css/guest/template.css')
    @vite('resources/css/guest/daysUntilExpo.css')
    @vite('resources/css/guest/glassimorfismo.css')
    @vite('resources/css/guest/cronograma.css')

    @vite([
        'resources/js/guest/expandImage.js',
        'resources/js/guest/daysUntilExpo.js',
        'resources/js/guest/cronogramaS1.js',
        'resources/js/guest/cronogramaS2.js',
        'resources/js/guest/cronogramaS3.js',
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

        <img src="{{ asset('assets/guest/Cancha_v1.png') }}" class="header-expo-bg" style="padding: 0" />

        <div class="container-gradient">

            <h1 class="title">HORARIO</h1>

            <section class="section-horario">

                <div class="container-grid-horario">

                    <div>
                        <button id="show-map" class="glassBtn icon btnAnimation" style="--btn-filter: url(#btn-glass);">
                            <img src="{{ asset('assets/guest/arrow.svg') }}">
                        </button>
                        <div class="container-grid-horario-map">
                            <div class="glassContainer horario-map" style="--glass-filter: url(#container-glass);">
                                <canvas id="MapaInteractivo"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="container-grid-horario-flyer">
                        <img id="eventsMap" src="{{ asset('assets/guest/Aula8_Cronograma.png') }}"
                            class="img-fluid horario-flyer" />
                    </div>

                </div>

                <div class="container-gradient-segment-horario"></div>

            </section>

        </div>
    </div>

    </div>

    </div>


    <svg style="display: none">
        <filter id="container-glass" x="0%" y="0%" width="100%" height="100%">
            <feTurbulence type="fractalNoise" baseFrequency="0.001 0.001" numOctaves="4" seed="91" result="noise" />
            <feGaussianBlur in="noise" stdDeviation="0.02" result="blur" />
            <feDisplacementMap in="SourceGraphic" in2="blur" scale="-77" xChannelSelector="R" yChannelSelector="G" />
        </filter>
        <filter id="btn-glass" primitiveUnits="objectBoundingBox">
            <feGaussianBlur in="SourceGraphic" stdDeviation="0.02" result="blur" />
            <feDisplacementMap in="blur" in2="blur" scale="0.1" xChannelSelector="R" yChannelSelector="G" />
        </filter>
    </svg>

</body>

</html>