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

            <section class="container-sponsors">
                <x-guest.sponsor-card :imageUrl="asset('assets/guest/sponsor(1).svg')" />
                <x-guest.sponsor-card :imageUrl="asset('assets/guest/sponsor(2).svg')" />
                <x-guest.sponsor-card :imageUrl="asset('assets/guest/sponsor(3).svg')" />
                <x-guest.sponsor-card :imageUrl="asset('assets/guest/sponsor(1).svg')" />
                <x-guest.sponsor-card :imageUrl="asset('assets/guest/sponsor(2).svg')" />
                <x-guest.sponsor-card :imageUrl="asset('assets/guest/sponsor(1).svg')" />
                <x-guest.sponsor-card :imageUrl="asset('assets/guest/sponsor(2).svg')" />
                <x-guest.sponsor-card :imageUrl="asset('assets/guest/sponsor(3).svg')" />
                <x-guest.sponsor-card :imageUrl="asset('assets/guest/sponsor(1).svg')" />
                <x-guest.sponsor-card :imageUrl="asset('assets/guest/sponsor(2).svg')" />
            </section>
        </div>
    </div>

</body>

</html>