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
    .section-portafolio {
        margin-inline: 10rem;
        grid-template-columns: min-content min-content min-content min-content;
    }

    .project-card-slot {
        position: static;
        padding: 1rem;
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
</style>

<body>

    {{-- Navbar --}}
    <div class="bg-navbar d-none"></div>
    <header class="hero">
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

        {{-- MENÚ DINÁMICO --}}
        <div class="portafolio-menu">
            <a href="{{ route('portafolio.index', ['category' => 'todos']) }}" class="btn-portafolio BrunoAce-font">
                Todos
            </a>

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
                // 1. Obtener objeto portada
                $portada = $proyecto->multimedia->where('es_portada', true)->first();

                if ($portada) {
                    $ruta = $portada->url;

                    // 2. CORRECCIÓN: Verificar si es URL externa (Seeder) o Archivo Local (Upload)
                    if (str_starts_with($ruta, 'http')) {
                        // Es un link externo (ej: via.placeholder.com), se usa tal cual
                        $finalUrl = $ruta;
                    } else {
                        // Es un archivo local, agregamos el path de storage
                        $finalUrl = asset('storage/' . $ruta);
                    }

                    $bgStyle = "background-image: url('$finalUrl');";
                }
            @endphp

            <a href="{{ route('proyecto.show', $proyecto->slug) }}">
                <x-guest.project-card
                    class="project-card-bg"
                    :style="$bgStyle"
                    :materia="$proyecto->materia->nombre ?? 'Materia desconocida'"
                    :nombreProyecto="$proyecto->titulo"
                />
            </a>

        @empty
            <div style="grid-column: 1 / -1; text-align: center; color: white; padding: 2rem;">
                <p>No hay proyectos disponibles en esta categoría por el momento.</p>
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