<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>EXPO LMAD - Landing Page</title>
    @vite(['resources/css/guest/landing-page.css',
    'resources/js/guest/revealAnimation.js'])

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
            Desde 2009, la Licenciatura en Multimedia y Animación Digital se ha
            consolidado como una licenciatura de innovación tecnológica y creativa.
            Somos el punto de encuentro exacto donde el rigor de las ciencias exactas
            y la visión artística convergen. Nuestro objetivo es formar especialistas
            capaces de diseñar mundos únicos y experiencias inmersivas que desafían
            los límites de la realidad. Un profesional de LMAD comprende las metodologías
            de las tecnologías de la información con la misma fluidez con la que expresa
            el arte, creando soluciones de diseño estratégico, interactivo y audiovisual
            que transforman nuestra forma de interactuar con el entorno digital.</p>
    </section>

    <section class="projects-container">

        <div class="project-row reveal">
            <div class="project-content glow-blue">
                <h2>Videojuegos</h2>
                <p>
                    La creación de un videojuego es el máximo reto de colaboración
                    tecnológica, y en LMAD lo convertimos en nuestro ecosistema
                    natural. Nuestros estudiantes trabajan en células multidisciplinarias
                    (fusionando el talento de artistas 2D y 3D con programadores)
                    para conceptualizar, desarrollar y publicar proyectos jugables en el
                    transcurso de un solo semestre. Con un comprendimiento de los motores
                    gráficos líderes en la industria, como Unreal Engine 5 y Unity,
                    construimos experiencias interactivas optimizadas tanto para PC
                    como para plataformas móviles, demostrando que, en nuestra facultad,
                    el arte y la lógica de programación pueden convivir en un mismo espacio.
                </p>
                <a href="{{ route('portafolio.index') }}" class="project-link">Ver proyectos &rarr;</a>
            </div>
            <div class="project-image glow-blue">
                <img src="{{ asset('assets/guest/EXPOLMAD-Vid.JPG') }}" alt="Videojuegos">
            </div>
        </div>


        <div class="project-row reverse reveal">
            <div class="project-content glow-purple">
                <h2 class="project-title">Arte</h2>
                <p class="project-description">
                    El arte dentro de LMAD va mucho más allá de la estética; es
                    diseño funcional con un propósito claro. Esta área es el motor
                    visual de nuestra carrera, abarcando la precisión técnica del
                    modelado 3D, la expresión del arte 2D, la postproducción y VFX
                    para crear narrativa cinematográfica en producciones audiovisuales.
                    Cada polígono, cada fotograma y cada composición están pensados
                    para comunicar mensajes poderosos, construir interfaces inolvidables
                    y darle alma a la tecnología. Nuestros estudiantes crean la identidad
                    visual del futuro.
                </p>
                <a href="{{ route('portafolio.index') }}" class="project-link">Ver proyectos &rarr;</a>
            </div>
            <div class="project-image glow-purple">
                <img src="{{ asset('assets/guest/ExpoLmadArte.jpeg') }}" alt="Arte">
            </div>
        </div>
        <div class="project-row reveal">
            <div class="project-content glow-pink">
                <h2 class="project-title">Programación</h2>
                <p class="project-description">
                    El código es nuestra herramienta para construir el mundo digital.
                    Nuestros desarrolladores aplican el espectro completo de la
                    programación: desde la creación de robustas bases de datos y
                    complejas arquitecturas back-end, hasta el desarrollo ágil de
                    aplicaciones y plataformas front-end. Sin embargo, lo que eleva a un
                    programador de LMAD por encima del resto es su profunda sensibilidad
                    hacia el diseño. Nuestros estudiantes desarrollan software funcional
                    y optimizado; integrando su formación artística para garantizar una
                    UI impecable y una UX intuitiva.
                </p>
                <a href="{{ route('portafolio.index') }}" class="project-link">Ver proyectos &rarr;</a>
            </div>
            <div class="project-image glow-pink">
                <img src="{{ asset('assets/guest/EXPOLMAD-PROGRA.JPG') }}" alt="Programación">
            </div>
        </div>


    </section>


    <footer class="footer"></footer>

</body>

</html>