/*----- LÓGICA: Botones y cambio de tabla -----*/
const btnRev = document.getElementById("btn-revisión");
const btnAcept = document.getElementById("btn-aceptado");

const tablaRevision = document.getElementById("tabla-revision");
const tablaAceptados = document.getElementById("tabla-aceptados");
const subtitle = document.querySelector(".subtitle");

btnRev.addEventListener("click", () => {
    cambiarVista("Proyectos en revisión", btnRev, "revision");
});

btnAcept.addEventListener("click", () => {
    cambiarVista("Proyectos aceptados", btnAcept, "aceptados");
});

function cambiarVista(nuevoTitulo, botonActivo, modo) {
    subtitle.innerText = nuevoTitulo;

    if (modo === "revision") {
        tablaRevision.classList.remove("hidden");
        tablaAceptados.classList.add("hidden");
    } else {
        tablaRevision.classList.add("hidden");
        tablaAceptados.classList.remove("hidden");
    }

    paginaActual = 1;

    actualizarPaginacion();
    actualizarBotones(botonActivo);
}

function actualizarBotones(botonActivo) {
    document.querySelectorAll(".tab-btn").forEach((btn) => {
        btn.classList.remove("active");
    });
    botonActivo.classList.add("active");
}

/*----- LÓGICA: Paginación -----*/
let paginaActual = 1;
const filasPorPagina = 5;

const btnPrev = document.querySelector(".page-arrow.prev");
const btnNext = document.querySelector(".page-arrow.next");
const pageDisplay = document.querySelector(".page-number");

function actualizarPaginacion() {

    const tablaActiva = document.querySelector(".table-wrapper:not(.hidden)");
    const filas = Array.from(tablaActiva.querySelectorAll("tbody tr"));

    const totalPaginas = Math.ceil(filas.length / filasPorPagina);

    if (paginaActual > totalPaginas) paginaActual = totalPaginas;
    if (paginaActual < 1) paginaActual = 1;


    filas.forEach((fila, index) => {
        const inicio = (paginaActual - 1) * filasPorPagina;
        const fin = inicio + filasPorPagina;

        if (index >= inicio && index < fin) {
            fila.style.display = "";
        } else {
            fila.style.display = "none";
        }
    });


    pageDisplay.innerText = paginaActual;

    btnPrev.style.opacity = paginaActual === 1 ? "0.3" : "1";
    btnNext.style.opacity = paginaActual >= totalPaginas ? "0.3" : "1";
}

/*----- EVENTOS DE LAS FLECHAS -----*/

btnPrev.addEventListener("click", () => {
    if (paginaActual > 1) {
        paginaActual--;
        actualizarPaginacion();
    }
});

btnNext.addEventListener("click", () => {
    const tablaActiva = document.querySelector(".table-wrapper:not(.hidden)");
    const filas = tablaActiva.querySelectorAll("tbody tr").length;
    const totalPaginas = Math.ceil(filas / filasPorPagina);

    if (paginaActual < totalPaginas) {
        paginaActual++;
        actualizarPaginacion();
    }
});

actualizarPaginacion();

/*----- LÓGICA: Modal -----*/
var idProyecto = 0;

window.prepararModal = prepararModal;

async function prepararModal(id) {

    try {
        const response = await fetch(`/api/obtener-proyecto-id/${id}`);

        if (!response.ok) {
            throw new Error("No se pudo obtener la información del proyecto");
        }

        const proyecto = await response.json();

        abrirModal(proyecto);

    } catch (error) {
        console.error("Error al cargar el proyecto:", error);

    }
}

function abrirModal(proyecto) {
    const modal = document.getElementById("modal-proyecto");
    const copyIconUrl = modal.getAttribute('data-copy-icon');
    idProyecto = 0;

    if (modal) {
        modal.classList.remove("hidden");
        document.body.style.overflow = "hidden";

        //console.log(proyecto);

        const modalTitulo = document.getElementById("modal-titulo");
        modalTitulo.innerText = '';
        modalTitulo.innerText = proyecto.titulo;

        const modalMateria = document.getElementById("modal-materia");
        modalMateria.innerText = '';
        modalMateria.innerText = proyecto.materia.nombre;

        const modalId = document.getElementById("modal-id");
        modalId.innerText = '';
        modalId.innerText = proyecto.id;
        idProyecto = proyecto.id;

        const modalSemestre = document.getElementById("modal-semestre");
        modalSemestre.innerText = '';
        modalSemestre.innerText = proyecto.materia.semestre;

        const modalDocente = document.getElementById("modal-maestro");
        modalDocente.innerText = '';
        modalDocente.innerText = proyecto.profesor.nombre + " " + proyecto.profesor.apellido_paterno + " " + proyecto.profesor.apellido_materno;

        const modalStudentList = document.getElementById("students-list");
        modalStudentList.innerHTML = '';
        proyecto.autores.forEach(autor => {
            modalStudentList.innerHTML +=
                `<div class="student-item">
                <span class="student-name">${autor.nombre + " " + autor.apellido_paterno + " " + autor.apellido_materno}</span>
                <span class="student-id">${autor.matricula}</span>
            </div>`;
        });

        const modalDescripcion = document.getElementById("modal-descripcion");
        modalDescripcion.innerText = '';
        modalDescripcion.innerText = proyecto.descripcion;

        const modalImagen = document.getElementById("modal-imagen");
        modalImagen.src = '';
        modalImagen.alt = 'No hay imagen';

        const modalLinks = document.getElementById("modal-links-section");
        modalLinks.innerHTML = '';


        proyecto.multimedia.forEach(multimedia => {
            if (multimedia.tipo === 'github') {
                modalLinks.innerHTML +=
                    `<div class="info-row">
                    <span class="label">ENLACE A PROYECTO (GITHUB):</span>
                    <div class="link-wrapper">
                        <a href="${multimedia.url}" id="modal-proyecto-url" class="url-text" target="_blank">${multimedia.url}</a>
                        <button class="btn-copy">
                            <img src="${copyIconUrl}" alt="Copiar">
                        </button>
                     </div>
                </div>`;
            }

            if (multimedia.tipo === 'drive') {
                modalLinks.innerHTML +=
                    `<div class="info-row">
                    <span class="label">ENLACE A PROYECTO (DRIVE):</span>
                        <div class="link-wrapper">
                            <a href="${multimedia.url}" id="modal-proyecto-url" class="url-text" target="_blank">${multimedia.url}</a>
                            <button class="btn-copy">
                                <img src="${copyIconUrl}" alt="Copiar">
                            </button>
                        </div>
                </div>`;
            }

            if (multimedia.tipo === 'youtube') {
                modalLinks.innerHTML +=
                    `<div class="info-row">
                    <span class="label">VIDEO PROMOCIONAL (YOUTUBE):</span>
                        <div class="link-wrapper">
                            <a href="${multimedia.url}" id="modal-video-url" class="url-text" target="_blank">${multimedia.url}</a>
                            <button class="btn-copy">
                                <img src="${copyIconUrl}" alt="Copiar">
                            </button>
                        </div>
                </div>`;
            }


            if (multimedia.tipo === 'imagen') {
                modalImagen.src = multimedia.url;
            }
        });

    }
}

function cerrarModal() {
    const modal = document.getElementById("modal-proyecto");
    idProyecto = 0;
    if (modal) {
        modal.classList.add("hidden");
        document.body.style.overflow = "auto";
    }
}

window.abrirModal = abrirModal;
window.cerrarModal = cerrarModal;

document.addEventListener("DOMContentLoaded", () => {
    const btnCerrar = document.getElementById("btn-cerrar-modal");
    const btnX = document.getElementById("btn-x-modal");
    const modalOverlay = document.getElementById("modal-proyecto");

    if (btnCerrar) btnCerrar.onclick = cerrarModal;
    if (btnX) btnX.onclick = cerrarModal;

    if (modalOverlay) {
        modalOverlay.onclick = (e) => {
            if (e.target === modalOverlay) cerrarModal();
        };
    }
});

const mandarRevisionButton = document.getElementById("btn-mandar-modal");

mandarRevisionButton.addEventListener("click", () => {

    if (idProyecto === 0) {
        alert("No es un numero valido para mandar a revision");
        return;
    }

    fetch(`/superadmin/mandarRevisionProyecto/${idProyecto}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en el servidor: ' + response.statusText);
            }
            return response.json();
        })
        .then(dataServido => {
            cerrarModal();
            window.location.reload();

        })
        .catch(error => {
            console.error("Error: ", error);
        });


});