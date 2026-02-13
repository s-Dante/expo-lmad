@vite(['resources/css/components/sidebar.css'])
@vite(['resources/js/components/sidebar.js'])

<aside class="role-sidebar">
    <button class="sidebar-toggle" id="sidebarToggle">
        <span class="span-sidebar"></span>
        <span class="span-sidebar"></span>
        <span class="span-sidebar"></span>
    </button>

    <div class="sidebar-top">
        <img class="logo-sidebar" src="{{ asset('assets/guest/LOGOEXPO2.png') }}" alt="" />
    </div>

    <!-- NAVBAR PARA PROFESORES -->
    <nav class="sidebar-nav">
        @if(auth()->user()->rol == 'profesor')

        <a href="{{ route('teacher.registro-expositores') }}" class="sidebar-item ">
            <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Expositor-1.png') }}" alt="" />
            <span class="span-sidebar">Registrar Expositores</span>
        </a>

        <a href="{{ route('teacher.lista-proyectos') }}" class="sidebar-item ">
            <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Public-1.png') }}" alt="" />
            <span class="span-sidebar">Mostrar Proyectos</span>
        </a>
        <!-- FIN NAVBAR PARA PROFESORES -->

        <!-- NAVBAR PARA ESTUDIANTES -->
        @elseif(auth()->user()->rol == 'estudiante')
        <nav class="sidebar-nav">
            {{-- Tome los iconos que encontre (cambiar si es necesario) --}}
            <a href="{{ route('estudiante.dashboard') }}" class="sidebar-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Public-1.png') }}" alt="" />
                <span class="span-sidebar">Panel de Administración</span>
            </a>

            <a href="{{ route('estudiante.proyectos.index') }}" class="sidebar-item {{ request()->routeIs('student.proyectos.*') ? 'active' : '' }}">
                <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Public-1.png') }}" alt="" />
                <span class="span-sidebar">Mis Proyectos</span>
            </a>

            <a href="{{ route('estudiante.qr') }}" class="sidebar-item {{ request()->routeIs('student.qr') ? 'active' : '' }}">
                <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Expositor-1.png') }}" alt="" />
                <span class="span-sidebar">Mi Pase (QR)</span>
            </a>
        </nav>
        <!-- FIN NAVBAR PARA ESTUDIANTES -->

        <!-- NAVBAR PARA SUPER ADMIN -->
        @elseif(auth()->user()->rol == 'super_admin')
        <a href="{{ route('superadmin.dashboard') }}" class="sidebar-item ">
            <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Home-1.png') }}" alt="" />
            <span class="span-sidebar">Inicio</span>
        </a>

        <a href="" class="sidebar-item ">
            <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Teachers-1.png') }}" alt="" />
            <span class="span-sidebar">Maestros</span>
        </a>

        <a href="" class="sidebar-item ">
            <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Idea-1.png') }}" alt="" />
            <span class="span-sidebar">Proyectos</span>
        </a>
        <!-- FIN DEL NAVBAR PARA SUPER ADMIN -->
        @endif
    </nav>


    <div class="sidebar-bottom">
        <a href="{{ route('auth.logout') }}" class="sidebar-item ">
            <img class="sidebar-icon" src="{{asset('assets/components/sidebar/Exit-1.png')}}" alt="Salir">
            <span class="span-sidebar">Salir</span>
        </a>
    </div>

</aside>