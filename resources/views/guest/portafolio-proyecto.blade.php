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

<style>
    @import url("https://fonts.googleapis.com/css2?family=Bruno+Ace&display=swap");
    @import url('https://fonts.googleapis.com/css2?family=Kodchasan&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=League+Spartan&display=swap');

    body {
        height: auto;
    }

    h1 {
        margin-top: 2rem;
        margin-bottom: 0.5rem;
        justify-content: center;
        flex-shrink: 0;
        text-align: center;
        font-size: 30px;
    }

    .BrunoAce-font {
        color: #fff;
        font-family: Bruno Ace;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .section-proyecto-materia {
        color: #00afc4;
        text-transform: uppercase;
    }

    .section-proyecto-nombre {
        justify-self: center;
    }

    .navbar {
        justify-content: space-between;
        z-index: 9 !important;
    }

    .hero-logo-container {
        justify-self: left;
        display: flex;
        flex-direction: column;
    }

    .hero-logo {
        justify-self: left;
        position: absolute;
        z-index: 9 !important;
        width: 4rem;
        filter: brightness(85%);
    }

    .hero-banner {
        height: 85%;
        position: relative;
        top: 12%;
        filter: blur(5px);
    }

    .hr-gradient {
        width: 80%;
        height: 0px;
        flex-shrink: 0;
        margin-top: 10px;
        z-index: 7 !important;
        border-radius: 63px;
        border-width: 0px;
        border-style: initial;
        border-color: initial;
        border-image: initial;
        background: linear-gradient(270deg,
                rgb(11, 26, 43) 2.34%,
                #00EBD2 49.54%,
                rgb(11, 26, 43) 100%);
    }

    .container-proyecto {
        justify-content: center;
        display: grid;
        grid-template-columns: min-content auto min-content;
        align-items: center;
        text-align: center;
    }

    .section-proyecto-info {
        justify-content: center;
        justify-self: center;
    }

    .container-proyecto-info {
        margin-inline: 1rem;
        display: grid;
        grid-template-columns: auto;
        align-items: center;
        text-align: center;
        justify-content: center;
        justify-items: center;
        margin-top: 2rem;
    }

    .container-proyecto-info p {
        color: #fff;
        font-family: Kodchasan;
        font-weight: 700;
    }

    .section-proyecto-header {
        padding: 1.3rem;
        position: absolute;
        justify-content: center;
        justify-self: anchor-center;
        width: inherit;
        top: 28%;
    }

    .container-baner {
        display: grid;
        overflow: hidden;
        grid-template-columns: auto;
    }

    .img-proyecto {
        width: 160px;
        height: 159px;
        box-shadow: rgba(153, 88, 245, 0.25) 0px 0px 50px 4px;
        border-radius: 40px;
        border-width: 1.5px;
        border-style: solid;
        border-color: rgb(153, 88, 245);
        border-image: initial;
        background: 50% center / cover no-repeat lightgray;
    }

    .video-project {
        border: 1.5px solid #368BE6;
        background: lightgray 50% / cover no-repeat;
        box-shadow: 0px 4px 50px 4px rgba(54, 139, 230, 0.30);
        width: 80vw;
        min-height: 100%;
        height: auto;
    }

    .container-proyecto-video {
        display: flex;
        justify-content: center;
    }

    .container-proyecto-equipo{
        justify-content: center;
    }

    .container-proyecto-equipo p{
        color: #fff;
    }

    .equipo-nombres{
        justify-self: center;
    }

    .equipo-nombres p{
        color: #fff;
        font-family: League Spartan;
        text-transform: uppercase;
    }

    .equipo-head{
        margin-top: 1rem;
        align-self: center;
        display: grid;
        grid-template-columns: max-content max-content max-content;
        justify-self: center;
    }

    .equipo-head-equipo{
        margin: 0rem;
    }

    @media (max-width: 590px) {
        .section-proyecto-materia {
            font-size: 1.2rem;
        }

        .section-proyecto-nombre {
            font-size: 1.2rem;
        }

    }

    @media (max-height: 605px) {
        .hero {
            overflow: visible;
        }

        .hero-banner {
            height: 110%;
        }
    }

    @media (max-height: 350px) {
        .hero-banner {
            top: 55%;
        }
    }
</style>

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