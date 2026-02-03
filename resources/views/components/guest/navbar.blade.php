<div class="bg-navbar d-none"></div>
<nav class="navbar unselectable">
    <div class="navbar-actions">
        <button class="btn-menu" aria-label="Menu" onclick="showButtons()">
            <img src="{{ asset('assets/guest/btn-burger-grad.png') }}" alt="Botón de menú" />
        </button>

        <a href="#" class="btn btn-purple-nav">Prueba</a>
        <a href="#" class="btn btn-darkpur-nav">Prueba</a>

        <a href="#" class="btn btn-ghost-nav">Portafolio</a>
        <a href="{{ route('login') }}" class="btn btn-blue-nav">Iniciar Sesión</a>
    </div>
</nav>