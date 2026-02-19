 @vite([
    'resources/js/guest/showButtonMenu.js'
    ])
</head>
<div class="bg-navbar d-none"></div>
<nav class="navbar unselectable">
    <div class="navbar-actions">
        <button class="btn-menu" aria-label="Menu" onclick="showButtons()">
            <img src="{{ asset('assets/guest/btn-burger-grad.png') }}" alt="Botón de menú" />
        </button>

        <a href="" class="btn btn-purple-nav">Mapa del evento</a>
        <a href="{{ route('cronograma') }}" class="btn btn-darkpur-nav">Cronograma</a>

        <a href="{{ route('portafolio.index') }}" class="btn btn-ghost-nav">Portafolio</a>
        <a href="{{ route('login') }}" class="btn btn-blue-nav">Iniciar Sesión</a>
    </div>
</nav>