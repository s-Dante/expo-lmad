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
function abrirModal() {
    const modal = document.getElementById("modal-proyecto");
    if (modal) {
        modal.classList.remove("hidden");
        document.body.style.overflow = "hidden"; 
    }
}
function cerrarModal() {
    const modal = document.getElementById("modal-proyecto");
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