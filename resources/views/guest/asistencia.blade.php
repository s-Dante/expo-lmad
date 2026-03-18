<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portafolio - EXPO LMAD</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/guest/registro.css',
        'resources/css/components/sidebar.css',
        'resources/js/guest/actions-registro.js'
    ])
</head>

<body>

    <header class="hero">
        <div class="bg-navbar d-none"></div>
        <img src="{{ asset('assets/guest/expolmadimg.png') }}" alt="EXPO LMAD" class="hero-banner" />
        <img src="{{ asset('assets/guest/LMAD_BLOOM.png') }}" class="hero-logo">
        <x-guest.navbar />
    </header>

    <section>

        <form>

            <container class="card-expo">

                <p>Nombre completo</p>
                <input type="text">

                <p>Matrícula</p>
                <input type="text">

                <button class="btn btn-purple" id="btn-registrar"> Registrar </button>

            </container>

        </form>

    </section>


    <article class="card-info">
        <span>EXPO LMAD - Mayo - 2026</span>
        <img src="{{ asset('assets/guest/icon-arrow-down.png') }}" alt="" />
    </article>

</body>

</html>