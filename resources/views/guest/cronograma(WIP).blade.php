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

                    <div class="container-grid-horario-map">
                        <div class="glassContainer horario-map">
                            <canvas id="MapaInteractivo"></canvas>
                            <div class="glassContainer button-sm" id="MapaInteractivo-L1">
                                L1
                            </div>
                            <div class="glassContainer button-sm" id="MapaInteractivo-L2">
                                L2
                            </div>
                        </div>
                    </div>

                    <div class="container-grid-horario-flyer">
                        <img id="eventsMap" src="{{ asset('assets/guest/AmbassadorSchedules.jpg') }}"
                            class="img-fluid horario-flyer" />
                    </div>

                </div>

                <div class="container-gradient-segment-horario"></div>

            </section>

            <section class="section-conferencias">
                <h1 class="title-conferencias">CONFERENCIAS</h1>

                <div class="container-grid-conferencias">

                    <div class="container-grid-conferencias-flyer">
                        <img id="conference-image" src="{{ asset('assets/guest/CRONOGRAMA1.png') }}"
                            class="img-fluid conferencia-flyer" />
                    </div>

                    <div class="container-grid-conferencias-list"> </div>

                    <div style="max-width: 98dvw;overflow-x: scroll;margin: 0rem;">
                        <img id="conference-background-image" style="margin: 0rem;overflow-x: auto;"
                            class="confe-backimage" src="{{ asset('assets/guest/CRONOGRAMA1.png') }}" />
                    </div>

                </div>

            </section>

            <section class="section-talleres">
                <h1>TALLERES</h1>
            </section>

        </div>
    </div>

    </div>

    </div>


    <svg style="display: none">
        <filter id="container-glass" x="0%" y="0%" width="100%" height="100%">
            <feTurbulence type="fractalNoise" baseFrequency="0.008 0.008" numOctaves="2" seed="92" result="noise" />
            <feGaussianBlur in="noise" stdDeviation="0.02" result="blur" />
            <feDisplacementMap in="SourceGraphic" in2="blur" scale="77" xChannelSelector="R" yChannelSelector="G" />
        </filter>
        <filter id="btn-glass" primitiveUnits="objectBoundingBox">
            <feGaussianBlur in="SourceGraphic" stdDeviation="0.02" result="blur"></feGaussianBlur>
            <feDisplacementMap id="disp" in="blur" in2="map" scale="1" xChannelSelector="R" yChannelSelector="G" />
        </filter>
    </svg>

</body>

</html>