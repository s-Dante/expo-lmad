@vite(['resources/css/components/sidebar.css'])
@vite(['resources/js/components/sidebar.js'])

<aside class="role-sidebar">
    <button class="sidebar-toggle" id="sidebarToggle">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <div class="sidebar-top">
        <img class="logo-sidebar" src="{{ asset('assets/guest/LOGOEXPO2.png') }}" alt="" />
    </div>

    <!-- NAVBAR PARA PROFESORES -->
    @if(auth()->user()->rol == 'profesor')
        <nav class="sidebar-nav">
            <a href="{{ route('teacher.registro-expositores') }}" class="sidebar-item ">
                <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Expositor-1.png') }}" alt="" />
                <span>Registrar Expositores</span>
            </a>

            <a href="{{ route('teacher.lista-proyectos') }}" class="sidebar-item ">
                <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Public-1.png') }}" alt="" />
                <span>Mostrar Proyectos</span>
            </a>
        </nav>
    @endif
    <!-- FIN NAVBAR PARA PROFESORES -->

    <!-- NAVBAR PARA ESTUDIANTES -->
    @if(auth()->user()->rol == 'estudiante')
        <nav class="sidebar-nav">
            {{-- Tome los iconos que encontre (cambiar si es necesario) --}}
            <a href="{{ route('estudiante.dashboard') }}" class="sidebar-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Public-1.png') }}" alt="" />
                <span>Panel de Administración</span>
            </a>

            <a href="{{ route('estudiante.proyectos.index') }}" class="sidebar-item {{ request()->routeIs('student.proyectos.*') ? 'active' : '' }}">
                <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Public-1.png') }}" alt="" />
                <span>Mis Proyectos</span>
            </a>

            <a href="{{ route('estudiante.qr') }}" class="sidebar-item {{ request()->routeIs('student.qr') ? 'active' : '' }}">
                <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Expositor-1.png') }}" alt="" />
                <span>Mi Pase (QR)</span>
            </a>
        </nav>
    @endif
    <!-- FIN NAVBAR PARA ESTUDIANTES -->
     
    <div class="sidebar-bottom">
        <a href="{{ route('auth.logout') }}" class="sidebar-item ">
            <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Exit-1.png') }}" alt="" />
            <span>Salir</span>
        </a>
    </div>

</aside>