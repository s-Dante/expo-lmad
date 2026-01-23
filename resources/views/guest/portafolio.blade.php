<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LMAD</title>
    @vite('resources/css/guest/template.css')
    @vite('resources/css/guest/portafolio.css')

    @vite([
        'resources/js/guest/showButtonMenu.js'
    ])
</head>

<body>
    <div class="bg-navbar d-none"></div>
    <header class="hero">
        <img src="{{asset('assets/guest/expolmadimg.png')}}" alt="EXPO LMAD" class="hero-banner" />
        <img src="{{asset('assets/guest/LMAD_BLOOM.png')}}" class="hero-logo">
        <x-guest.navbar />
    </header>

    <section class="title-portafolio">
        <h1 class="BrunoAce-font" id="titulo"> Todos </h1>
        <center><input type="text" disabled class="hr-gradient"></center>
        <div class="portafolio-menu">
            <button class="btn-portafolio BrunoAce-font" data-category="todos">Todos</button>
            <button class="btn-portafolio BrunoAce-font" data-category="programacion">Programación</button>
            <button class="btn-portafolio BrunoAce-font" data-category="arte">Arte</button>
            <button class="btn-portafolio BrunoAce-font" data-category="rv">Realidad Virtual</button>
            <button class="btn-portafolio BrunoAce-font" data-category="videojuegos">Videojuegos</button>
        </div>
    </section>

    <section class="section-portafolio" id="proyectos">
        <x-guest.project-card></x-guest.project-card>
        <x-guest.project-card></x-guest.project-card>
        <x-guest.project-card></x-guest.project-card>
        <x-guest.project-card></x-guest.project-card>
        <x-guest.project-card></x-guest.project-card>
        <x-guest.project-card></x-guest.project-card>
    </section>

    <article class="card-info">
        <span>EXPO LMAD - Mayo - 2026</span>
        <img src="{{asset('assets/guest/icon-arrow-down.png')}}" alt="" />
    </article>

</body>

</html>