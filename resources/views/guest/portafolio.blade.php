<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portafolio - EXPO LMAD</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/guest/portafolio.css',
        'resources/js/guest/showButtonMenu.js'
    ])
</head>


<style>
    .title-portafolio {
        text-align: center;
    }

    .section-portafolio {
        margin-top: 2rem;
        display: grid;
        grid-template-columns: min-content min-content min-content min-content;
        justify-content: center;
        gap: 1rem;
    }

    .project-card-slot {
        position: static;
        padding: 1rem;
        overflow: visible;
        max-width: 15rem;
        max-height: 15rem;
    }

    .project-card-container {
        position: absolute;
    }

    /* Fondo dinámico para las cards */
    .project-card-bg {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    /* Paginación centrada */
    .pagination-container nav {
        display: flex;
        justify-content: center;
        padding: 2rem;
    }

    @media (max-width: 1130px) {
        .section-portafolio {
            margin-top: 4rem;
            grid-template-columns: min-content min-content min-content;
        }
    }

    @media (max-width: 870px) {
        .section-portafolio {
            margin-top: ;
            grid-template-columns: min-content min-content;
        }
    }

    @media (max-width: 580px) {
        .section-portafolio {
            grid-template-columns: min-content;
        }
    }

    .portafolio-menu {
        display: flex;
        justify-content: center;
        align-items: anchor-center;
        max-height: 1rem;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .project-card-subtitulo {
        font-family: Kodchasan;
        font-size: 1.7rem;
        color: #18e2ed00;
        margin: .6rem;
        transition: all .3s ease-out;
        max-height: 9rem;
        overflow: hidden;
    }

    .project-card-titulo {
        color: #fff0;
        text-align: left;
        font-family: Bruno Ace;
        font-size: 1.3rem;
        font-style: normal;
        line-height: normal;
        margin: .6rem;
        transition: all .3s ease-out;
    }
</style>

<body>

    {{-- Navbar --}}

    <header class="hero">
        <div class="bg-navbar d-none"></div>
        <img src="{{ asset('assets/guest/expolmadimg.png') }}" alt="EXPO LMAD" class="hero-banner" />
        <img src="{{ asset('assets/guest/LMAD_BLOOM.png') }}" class="hero-logo">
        <x-guest.navbar />
    </header>

    {{-- TÍTULO --}}
    <section class="title-portafolio">
        <h1 class="BrunoAce-font" id="titulo">
            {{ ucfirst($categoriaActiva) }}
        </h1>

        <center>
            <input type="text" disabled class="hr-gradient">
        </center>

        {{-- CAMBIO 1: MENÚ DINÁMICO DESDE LA BASE DE DATOS --}}
        <div class="portafolio-menu">
            {{-- El botón "Todos" siempre va fijo --}}
            <a href="{{ route('portafolio.index', ['category' => 'todos']) }}" class="btn-portafolio BrunoAce-font">
                Todos
            </a>

            {{-- Iteramos las categorías que trajimos de la tabla tbl_categorias --}}
            @foreach($categorias as $cat)
                <a href="{{ route('portafolio.index', ['category' => $cat->slug]) }}" class="btn-portafolio BrunoAce-font">
                    {{ $cat->nombre }}
                </a>
            @endforeach
        </div>
    </section>

    {{-- GRID DE PROYECTOS --}}
    <section class="section-portafolio" id="proyectos">
        @forelse($proyectos as $proyecto)

            @php
                $bgStyle = '';
                if ($proyecto->portada) {
                    // CAMBIO 2: Aseguramos usar 'url' que es como lo definimos en el modelo Multimedia
                    // Antes decía 'ruta_archivo', verifica cual es el nombre real en tu tabla
                    $url = asset('storage/' . $proyecto->portada->url);
                    $bgStyle = "background-image: url('$url');";
                }
            @endphp

            <a href="{{ route('proyecto.show', $proyecto->slug) }}">
                <x-guest.project-card class="project-card-bg" :style="$bgStyle" :materia="$proyecto->materia->nombre ?? 'Materia desconocida'" :nombreProyecto="$proyecto->titulo" />
            </a>

        @empty
            <div style="grid-column: 1 / -1; text-align: center; color: white;">
                <p>No hay proyectos disponibles en esta categoría.</p>
            </div>
        @endforelse
    </section>

    {{-- PAGINACIÓN --}}
    <div class="pagination-container">
        {{ $proyectos->links() }}
    </div>

    <article class="card-info">
        <span>EXPO LMAD - Mayo - 2026</span>
        <img src="{{ asset('assets/guest/icon-arrow-down.png') }}" alt="" />
    </article>

</body>

</html>