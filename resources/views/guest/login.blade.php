<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>EXPO LMAD - Iniciar Sesión</title>
    @vite(['resources/css/guest/login.css'])
</head>

<body>
    <main class="log-in">
        <img class="planet" src="{{ asset('assets/guest/planet-1.png') }}" alt="" />

        <header class="text-top">EXPANDIENDO LA REALIDAD</header>
    </main>
    <form class="login-form" action="#" method="post">
        <img class="logo-w" src="{{ asset('assets/guest/LOGOEXPO2.png') }}" alt="" />

        <div class="input-container">
            <div class="input-group">
                <input
                    type="text"
                    class="input-clave"
                    placeholder="Clave de usuario" />
                <span class="line"></span>
            </div>

            <div class="input-group">
                <input
                    type="password"
                    class="input-contrasena"
                    placeholder="Contraseña" />
                <span class="line"></span>
            </div>

            <a href="#" class="btn btn-purple">Iniciar Sesión</a>
        </div>
    </form>
</body>

</html>