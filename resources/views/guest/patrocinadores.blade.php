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
            <a href="/" class="header-logo">
                <img class="header-logo" src="{{ asset('assets/guest/LOGOEXPO2.png') }}">
            </a>

            <x-guest.timer />
        </div>

        <x-guest.navbar />
    </header>

    <div class="body-container-expo-schedule">
        <img src="{{ asset('assets/guest/Cancha_v1.png') }}" class="header-expo-3" style="padding: 0" />

        <div class="container-gradient">
            <h1 class="title">MUY PRONTO</h1>
        </div>
    </div>

</body>

</html>