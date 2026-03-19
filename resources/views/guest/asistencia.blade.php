<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Asistencia AFI - EXPO LMAD</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/guest/registro.css',
        'resources/css/components/sidebar.css',
        'resources/js/guest/afi/actions-registro.js',
        'resources/js/guest/afi/attendace-afi.js'
    ])
</head>

<body>

   <header class="hero">
        <div class="bg-navbar d-none"></div>
        <img src="{{ asset('assets/guest/expolmadimg.png') }}" alt="EXPO LMAD" class="hero-banner" />
        <x-guest.header-title>Asistencia de AFI</x-guest.header-title>
        <x-guest.navbar />
    </header>

    <section class="section-main">

        <form id="form" name="form">

            <container class="card-expo">

                <p>ID</p>
                <input type="text" id="studentId" name="studentId">

                <p>Palabra clave</p>
                <input type="text" id="key" name="key">

                <button class="btn btn-purple" id="btn-registrar" name="btn-registrar"> Registrar </button>

            </container>

        </form>

    </section>


    <article class="card-info">
        <span>EXPO LMAD - Mayo - 2026</span>
        <img src="{{ asset('assets/guest/icon-arrow-down.png') }}" alt="" />
    </article>

</body>

</html>