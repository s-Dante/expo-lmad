<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LMAD</title>
    @vite('resources/css/guest/template.css')
    @vite('resources/css/guest/portafolio-proyecto.css')

    @vite([
        'resources/js/guest/showButtonMenu.js'
    ])
</head>

<body>
    <header class="hero">
        <div class="bg-navbar d-none"></div>
        <x-guest.navbar-logo />

        <container class="section-proyecto-header">
            <h1 class="BrunoAce-font section-proyecto-materia">Administración de Alto Volumen de datos</h1>
            <center><input type="text" disabled class="hr-gradient"></center>
            <container class="container-proyecto">
                <x-guest.bracket-left />
                <h2 class="BrunoAce-font section-proyecto-nombre">Nombre del proyecto</h2>
                <x-guest.bracket-right />
            </container>
        </container>
        <container class="container-banner">
            <img src="{{asset('assets/guest/expolmadimg.png')}}" alt="EXPO LMAD" class="hero-banner" />
        </container>
    </header>

    <section class="section-proyecto-info" id="">
        <contianer class="container-proyecto-info">
            <img class="img-proyecto" src="{{ asset('assets/guest/CRONOGRAMA1.png') }}">
            <p>Lorem ipsum. Alere flama veriatatis. Relleno. Ayuda.</p>
        </contianer>
        <container class="container-proyecto-video">
            <iframe
                src="https://www.youtube.com/embed/watch?v=3DylGj3gNqY&list=PL1JpS8jP1wgAm1z3ntJZQ0ef9vokjJ56Z&index=3"
                class="video-project img-fluid" frameborder="0"
                allow="accelerometer; autoplay=true; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen="" autoplay="true">
            </iframe>
        </container>
        <container class="container-proyecto-equipo">
            <div class="equipo-head">
                <x-icons.left-bracket />
                <h1 class="BrunoAce-font equipo-head-equipo">Equipo</h1>
                <x-icons.right-bracket />
            </div>
            <div class="equipo-nombres">
                <p>Estela Amarillo Tilin Champurrado</p>
            </div>
        </container>
    </section>

    <article class="card-info">
        <span>EXPO LMAD - Mayo - 2026</span>
        <img src="{{asset('assets/guest/icon-arrow-down.png')}}" alt="" />
    </article>

</body>

</html>