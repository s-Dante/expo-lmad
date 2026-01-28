<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>EXPO LMAD - Landing Page</title>
    @vite(['resources/css/guest/landing-page.css'])
    @vite([
    'resources/js/guest/revealAnimation.js',
    'resources/js/guest/showButtonMenu.js'
    ])
</head>

<body>
    <div class="bg-navbar d-none"></div>
    <header class="hero">
        <video
            class="hero-banner"
            autoplay
            muted
            loop
            playsinline>
            <source src="{{ asset('assets/guest/expolmad.mp4') }}" type="video/mp4">
            Tu navegador no soporta video.
        </video>
        <img src="{{ asset('assets/guest/LMAD-LOGO-2.png') }}" alt="EXPO LMAD" class="hero-logo" />

        <x-guest.navbar />
    </header>

    <section class="tex-presentation reveal">
        <h1>CARRERA</h1>
        <p>
            Para entender la historia de fnaf, hay q olvidarse q estos son juegos y
            quiero q tomen realmente está saga como lo q es de terror, Si pero sobre
            todo ciencia, ciencia ficción Q pasaría si dos amigos abren una
            pizzería, esa es la primera pregunta q hay q plantearnos, lo normal
            sería q todo vaya medianamente bien con algún tipo de problemas, pero
            nada saldría más allá q eso, la pregunta cambia completamente si nos
            preguntamos, ¿q pasaría si Henry y William abren una pizzería? </br><br>
            ¿Quienes son estos personajes? En un principio grandes amigos, Henry x
            un lado era un ferviente y talentoso, mecánico q cuidaba a su propia
            hija Charlie, no sabemos nada q le pasó a su esposa siquiera tiene a
            alguien más en su familia y x el otro lado William Afton, la familia de
            Afton estaba compuesta x cinco miembros.</p>
    </section>

    <section class="projects-container">

        <div class="project-row reveal">
            <div class="project-content glow-blue">
                <h2>Videojuegos</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</br><br>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </br><br>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                </p>
                <a href="#" class="project-link">Ver proyectos &rarr;</a>
            </div>
            <div class="project-image glow-blue">
                <img src="{{ asset('assets/guest/EXPOLMAD-Vid.JPG') }}" alt="Videojuegos">
            </div>
        </div>


        <div class="project-row reverse reveal">
            <div class="project-content glow-purple">
                <h2 class="project-title">Arte</h2>
                <p class="project-description">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</br><br>

                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </br><br>

                </p>
                <a href="#" class="project-link">Ver proyectos &rarr;</a>
            </div>
            <div class="project-image glow-purple">
                <img src="{{ asset('assets/guest/ExpoLmadArte.jpeg') }}" alt="Arte">
            </div>
        </div>
        <div class="project-row reveal">
            <div class="project-content glow-pink">
                <h2 class="project-title">Programación</h2>
                <p class="project-description">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</br><br>

                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </br><br>

                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                </p>
                <a href="#" class="project-link">Ver proyectos &rarr;</a>
            </div>
            <div class="project-image glow-pink">
                <img src="{{ asset('assets/guest/EXPOLMAD-PROGRA.JPG') }}" alt="Programación">
            </div>
        </div>


    </section>


    <footer class="footer"></footer>

    <article class="card-info">
        <span>EXPO LMAD - Mayo - 2026</span>
        <img src="img/icon-arrow-down.png" alt="" />
    </article>

</body>

</html>