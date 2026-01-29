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

     <nav class="sidebar-nav">
         <a href="{{ route('profesor.registro-expositores') }}" class="sidebar-item ">
             <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Expositor-1.png') }}" alt="" />
             <span>Registrar Expositores</span>
         </a>

         <a href="{{ route('profesor.lista-proyectos') }}" class="sidebar-item ">
             <img class="sidebar-icon" src="{{ asset('assets/components/sidebar/Public-1.png') }}" alt="" />
             <span>Mostrar Proyectos</span>
         </a>

     </nav>

     <div class="sidebar-bottom">
         <a href="#" class="sidebar-item ">
             <img
                 class="sidebar-icon"
                 src="{{ asset('assets/components/sidebar/Exit-1.png') }}"
                 alt="" />
             <span>Salir</span>
         </a>
     </div>

 </aside>

 