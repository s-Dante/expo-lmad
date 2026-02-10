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
            <h1 class="BrunoAce-font section-proyecto-materia">{{ $proyecto->materia->nombre }}</h1>
            <center><input type="text" disabled class="hr-gradient"></center>
            <container class="container-proyecto">
                <x-guest.bracket-left />
                <h2 class="BrunoAce-font section-proyecto-nombre">{{ $proyecto->titulo }}</h2>
                <x-guest.bracket-right />
            </container>
        </container>
        <container class="container-banner">
            <img src="{{asset('assets/guest/expolmadimg.png')}}" alt="EXPO LMAD" class="hero-banner" />
        </container>
    </header>

    <section class="section-proyecto-info" id="">

        @foreach($proyecto->multimedia as $media)
            {{-- 1. SI ES LA PORTADA (IMAGEN LOCAL) --}}
            @if ($loop->iteration > 2)
                @break
            @endif
            @if ($media->es_portada)
                <container class="container-proyecto-info">
                    {{-- CORRECCIÓN: Usar asset('storage/...') para generar la URL pública --}}
                    <img class="img-proyecto" src="{{ asset('storage/' . $media->url) }}">
                    <p>{{ $proyecto->descripcion }}</p>
                
                    <container class="container-proyecto-tags">
                        <p> Creado con </p>
                        <div class="tags-list">
                            @foreach($proyecto->softwares as $software)
                                <div class="tooltip">
                                    <p>
                                        {{ $software->nombre }}
                                    </p>
                                    <span class="tooltiptext">{{ $software->descripcion }}</span>
                                </div>
                            @endforeach
                        </div>
                    </container>
                </container>

            {{-- 2. SI NO ES PORTADA (ASUMIMOS QUE ES EL VIDEO DE YOUTUBE) --}}
            @else
                {{-- Nota: Validamos que sea tipo youtube para evitar errores si suben más imágenes --}}
                @if($media->tipo === 'youtube')
                    <container class="container-proyecto-video">
                        <iframe src="{{ $media->url }}" class="video-project img-fluid" frameborder="0"
                            allow="accelerometer; autoplay=true; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen="" autoplay="true">
                        </iframe>
                    </container>
                @endif
            @endif
        @endforeach
    </section>

    <container class="container-proyecto-equipo">
        @php
            $totalAutores = $proyecto->autores->count();
        @endphp
        <div class="equipo-head">
            <x-icons.left-bracket />
            <h1 class="BrunoAce-font equipo-head-equipo">{{ $totalAutores > 1 ? 'Equipo' : 'Alumno' }}</h1>
            <x-icons.right-bracket />
        </div>
        <div class="equipo-nombres">
            @foreach($proyecto->autores as $autor)
                <p>
                    {{ $autor->nombre }} {{ $autor->apellido_paterno }}
                </p>
            @endforeach

        </div>
    </container>

    <article class="card-info">
        <span>EXPO LMAD - Mayo - 2026</span>
        <img src="{{asset('assets/guest/icon-arrow-down.png')}}" alt="" />
    </article>

</body>

</html>