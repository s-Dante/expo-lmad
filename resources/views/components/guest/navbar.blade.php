<nav class="navbar unselectable">
    <div class="navbar-actions">
        <button class="btn-menu" aria-label="Menu" onclick="showButtons()">
            <img src="{{ asset('assets/guest/btn-burger-grad.png') }}" alt="Botón de menú" />
        </button>

        <a href="#" class="btn btn-purple">Prueba</a>
        <a href="#" class="btn btn-darkpur">Prueba</a>

        <a href="#" class="btn btn-ghost">Portafolio</a>
        <a href="{{ route('login') }}" class="btn btn-blue">Iniciar Sesión</a>
    </div>
</nav>
