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

{{-- 🔹 ESTILOS ORIGINALES (RESPETADOS) --}}
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

        {{-- FILTROS SERVER SIDE --}}
        <div class="portafolio-menu">
            @foreach(['todos', 'programacion', 'arte', 'rv', 'videojuegos'] as $cat)
                <a
                    href="{{ route('portafolio.index', ['category' => $cat]) }}"
                    class="btn-portafolio BrunoAce-font"
                >
                    {{ ucfirst($cat) }}
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
                    $url = asset('storage/' . $proyecto->portada->ruta_archivo);
                    $bgStyle = "background-image: url('$url');";
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
            <div style="grid-column: 1 / -1; text-align: center; color: white;">
                <p>No hay proyectos disponibles en esta categoría.</p>
            </div>
        @endforelse
    </section>

    {{-- PAGINACIÓN --}}
    {{-- Nota: el método links() genera automáticamente los enlaces de paginación, se debe de mejorar el diseño xd--}}
    <div class="pagination-container">
        {{ $proyectos->links() }}
    </div>

    <article class="card-info">
        <span>EXPO LMAD - Mayo - 2026</span>
        <img src="{{ asset('assets/guest/icon-arrow-down.png') }}" alt="" />
    </article>

</body>
</html>
