
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
    document.querySelector(".page-number").innerText = paginaActual;

    actualizarBotones(botonActivo);
}

function actualizarBotones(botonActivo) {
    document.querySelectorAll(".tab-btn").forEach((btn) => {
        btn.classList.remove("active");
    });
    botonActivo.classList.add("active");
}


/*----- LÓGICA: Paginación -----*/
const btnPrev = document.querySelector(".page-arrow.prev");
const btnNext = document.querySelector(".page-arrow.next");
const pageDisplay = document.querySelector(".page-number");

let paginaActual = 1;

btnPrev.addEventListener("click", () => {
    if (paginaActual > 1) {
        paginaActual--;
        actualizarTablaPorPagina();
    }
});

btnNext.addEventListener("click", () => {
    paginaActual++;
    actualizarTablaPorPagina();
});

function actualizarTablaPorPagina() {
    pageDisplay.innerText = paginaActual;


    const tabla = document.querySelector(".proyectos-table tbody");
    tabla.style.opacity = "0.5";
    
    setTimeout(() => {
        tabla.style.opacity = "1";
    }, 200);
}
