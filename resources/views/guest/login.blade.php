<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>EXPO LMAD - Iniciar Sesión</title>
    @vite([
    'resources/css/guest/login.css',
    "resources/css/components/alerts.css"
    ])
</head>

<body>

    <p class="text-top">EXPANDIENDO LA REALIDAD</p>

    <form class="login-form" action="{{ route('auth.login')}}" method="post">

        @csrf

        <a href="/" class="a-logo-w">
            <img class="logo-w" src="{{ asset('assets/guest/LOGOEXPO2.png') }}" alt="" />
        </a>

        <div class="input-container">
            <div class="input-group">
                <input name="email" type="text" placeholder="Clave de usuario" />
                <span class="line"></span>
            </div>

            <div class="input-group">
                <input name="password" type="password" placeholder="Contraseña" />
                <span class="line"></span>
            </div>

            <button type="submit" class="btn btn-purple">Iniciar Sesión</button>
        </div>
    </form>

    <img class="planet" src="{{ asset('assets/guest/planet-1.png') }}" alt="" />

    <script type="module">
        import {
            showServerMessages
        } from "{{ Vite::asset('resources/js/components/flash-alerts.js') }}";

        showServerMessages(
            @json(session('success')),
            @json(session('error')),
            @json($errors - > all())
        );
    </script>

</body>

</html>