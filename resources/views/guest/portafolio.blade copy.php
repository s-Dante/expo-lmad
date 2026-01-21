@extends('Templates/headerStruct')

@section('content')

<header class="header-index row justify-content-center mx-auto h-100" id="header-index" style="">
    <div style="position: relative; width: 100%; height:80%;">
        <video autoplay loop muted class="header-gif-expo img-fluid" id="video-header">
            <source src="{{asset('images/expolmad.mp4')}}" type="video/mp4">
            Tu navegador no admite el elemento de video.
        </video>
    </div>

    <div style="width: 50%; height: 0%;">
        <img src="{{asset('images/LMAD_BLOOM.png')}}" class="header-logo-lmad img-fluid" height="270" width="522"
            onclick="window.location.href = '{{ url('/') }}'">
    </div>
    <div class="panel-header-buttons notDisplay d-md-none" id="panelShow"> </div>

    <div class="header-buttons-div">

        <img src="{{asset('images/btn-burger-grad.png')}}" id="arrowShow" onclick="showButtons()"
            class="arrow-header notDisplay" />

        <div class="col-12 d-md-none"></div>

        <button class="header-btn-eventMap notDisplay" id="mapButton"
            onclick="window.location.href = '{{route('MapCI.index')}}'">Mapa del Evento</button>

        <div class="col-12 d-md-none"></div>

        <button class="header-btn-assistance notDisplay" id="assistanceButton"
            onclick="window.location.href = '{{route('AfiRegister.index')}}'">Asistencia</button>

        <div class="col-12 d-md-none"></div>

        <button class="header-btn-portfolio d-md-none notDisplay" id="portfolioButton"
            onclick="window.location.href = '{{route('Portfolio.index')}}'">Portafolio</button>

        <div class="col-12 d-md-none"></div>

        <button class="header-btn-Login d-md-none notDisplay" id="LoginButton"
            onclick="window.location.href = '{{route('inicioSesion.index')}}'">Iniciar
            Sesión</button>

        <div class="col-12 d-md-none"></div>

        <button class="header-btn-portfolio d-none d-md-block"
            onclick="window.location.href = '{{route('Portfolio.index')}}'">Portafolio</button>

        <div class="col-12 d-md-none"></div>

        <button class="header-btn-Login d-none d-md-block"
            onclick="window.location.href = '{{route('inicioSesion.index')}}'">Iniciar
            Sesión</button>

    </div>
</header>



<div class="portfolio-body justify-content-center" id="portfolio-body" style="height: fit-content;">
    <div class="title-portfolio">
        <p id="titulo" class="porfolio-text">{{$title}}</p>
        <!--hr class="hr-gradient" /-->
        <center><input type="text" disabled class="hr-gradient"></center>
        <div class="row justify-content-center mx-auto d-none d-lg-block" style="margin-bottom: 0.1rem;">
            <div class="col-sm-12 mb-5 d-flex align-items-center justify-content-center ">
                <button class="portfolio-btn" data-category="todos">Todos</button>
                <button class="portfolio-btn" data-category="programacion">Programación</button>
                <button class="portfolio-btn" data-category="arte">Arte</button>
                <button class="portfolio-btn" data-category="rv">Realidad Virtual</button>
                <button class="portfolio-btn" data-category="videojuegos">Videojuegos</button>
            </div>
        </div>
        <div class="row justify-content-center mx-auto d-lg-none" style="margin-bottom: 0.1rem;">
            <div class="col-sm-12 mb-5 d-flex align-items-center justify-content-center row">
                <button class="portfolio-btn" data-category="todos">Todos</button>
                <button class="portfolio-btn" data-category="programacion">Programación</button>
                <button class="portfolio-btn" data-category="arte">Arte</button>
                <button class="portfolio-btn" data-category="rv">Realidad Virtual</button>
                <button class="portfolio-btn" data-category="videojuegos">Videojuegos</button>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mx-5" id="contenedor-proyectos" style=" margin-bottom:3rem">
    </div>

    <div class="footer-card" onclick="window.location.href = '{{route('expo.index')}}'">
        <p class="footer-card-text">EXPO LMAD <i>EXPANDIENDO LA REALIDAD</p>
        <img width="17" height="17" src="{{asset('images/icon-arrow-down.png')}}" alt="expand-arrow--v2"
            class="arrow-footer" />
    </div>

</div>

<!--script>
        const image = document.querySelector('.card-proyect-portfolio');
        const shadowBox = document.querySelector('.card-subject-portfolio');
        const shadowText = document.querySelector('.card-proyect-portfolio-text');

        image.onload = function () {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.width = image.width;
            canvas.height = image.height;
            context.drawImage(image, 0, 0, canvas.width, canvas.height);

            const imageData = context.getImageData(0, 0, canvas.width, canvas.height).data;

            let maxColor = 0;
            for (let i = 0; i < imageData.length; i += 4) {
                const brightness = (imageData[i] + imageData[i + 1] + imageData[i + 2]) / 3;
                maxColor = Math.max(maxColor, brightness);
            }

            const shadowColor = `rgba(${maxColor}, ${maxColor}, ${maxColor}, 0.5)`;
            shadowBox.style.boxShadow = `0 0 20px ${shadowColor}`;
            shadowText.style.boxShadow = `0 0 20px ${shadowColor}`;
            shadowText.style.color = `0 0 20px ${shadowColor}`;
        };
    </script--->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const botones = document.querySelectorAll(".portfolio-btn");
        const titulo = document.getElementById("titulo");
        const contenedor = document.getElementById("contenedor-proyectos");

        function cargarProyectos(categoria, pagina = 1) {
            fetch(`/portfolio/filtrar/${categoria}?page=${pagina}`)
                .then(res => res.json())
                .then(json => {
                    const data = json.data;
                    const currentPage = json.current_page;
                    const lastPage = json.last_page;

                    contenedor.innerHTML = '';

                    if (data.length === 0) {
                        contenedor.innerHTML = '<p class="text-center title-event mt-4">No hay proyectos para esta categoría.</p>';
                        return;
                    }

                    data.forEach(project => {
                        contenedor.innerHTML += `
                            <div class="col-sm-2 mx-5 mb-5 d-flex align-items-center justify-content-center">
                                <div class="card-portfolio-container" onclick="window.location.href='/Portfolio/${project.id}'">
                                    <div class="card-portfolio" style="background-image: url('/storage/eventImages/${project.imagen_url}')">
                                        <div class="card-portfolio-filter d-flex align-content-end flex-wrap">
                                            <p class="card-text-portfolio">${project.subject}</p>
                                            <p class="card-portfolio-subtittle">${project.nameProject}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    if (lastPage > 1) {
                        let pagination = '<div class="text-center w-100 mt-3 mb-5"><nav class="mb-2"><ul class="pagination d-flex flex-row justify-content-center">';

                        // Botón "Anterior"
                        pagination += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                            <button class="page-link portfolio-btn" data-page="${currentPage - 1}" ${currentPage === 1 ? 'disabled' : ''}>« Anterior</button>
                        </li>`;

                        // Números de página
                        for (let i = 1; i <= lastPage; i++) {
                            pagination += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                                <button class="page-link portfolio-btn" data-page="${i}">${i}</button>
                            </li>`;
                        }

                        // Botón "Siguiente"
                        pagination += `<li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                            <button class="page-link portfolio-btn" data-page="${currentPage + 1}" ${currentPage === lastPage ? 'disabled' : ''}>Siguiente »</button>
                        </li>`;

                        pagination += '</ul></nav></div>';
                        contenedor.innerHTML += pagination;

                        document.querySelectorAll('.page-link').forEach(btn => {
                            btn.addEventListener('click', () => {
                                cargarProyectos(categoria, parseInt(btn.dataset.page));
                            });
                        });
                    }
                });
        }

        botones.forEach(btn => {
            btn.addEventListener("click", () => {
                const categoria = btn.getAttribute("data-category");
                titulo.innerText = categoria.charAt(0).toUpperCase() + categoria.slice(1);
                cargarProyectos(categoria);
            });
        });

        cargarProyectos("todos"); // carga inicial
    });
</script>


@endsection