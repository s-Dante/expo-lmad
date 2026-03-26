import { showModal } from "../components/alerts.js";

const radioAlumno = document.getElementById("alumno");
const radioExterno = document.getElementById("externo");
const containerMatricula = document.getElementById("container-matricula");
const inputMatricula = document.getElementById("matricula");

function toggleMatricula() {
    if (radioExterno.checked) {
        containerMatricula.classList.add("hidden-field");
        inputMatricula.value = "";
    } else {
        containerMatricula.classList.remove("hidden-field");
    }
}

radioAlumno.addEventListener("change", toggleMatricula);
radioExterno.addEventListener("change", toggleMatricula);

toggleMatricula();

const eventItems = document.querySelectorAll(".event-item");
const hiddenInput = document.getElementById("evento_seleccionado");

eventItems.forEach((item) => {
    item.addEventListener("click", () => {
        eventItems.forEach((i) => i.classList.remove("selected"));

        item.classList.add("selected");

        hiddenInput.value = item.getAttribute("data-value");
    });
});

/*---VALIDACIONES ---*/
const form = document.getElementById("form-eventos");

form.addEventListener("submit", (e) => {
    e.preventDefault();

    const tipoVisitante = document.querySelector(
        'input[name="tipo_visitante"]:checked',
    );
    const matriculaVal = document.getElementById("matricula").value.trim();
    const nombreVal = document.getElementById("nombre").value.trim();
    const eventoVal = document.getElementById("evento_seleccionado").value;

    const regexMatricula = /^\d{7,9}$/;
    if (!tipoVisitante) {
        showModal("Error", "Por favor selecciona si eres Alumno o Externo.");
        return;
    }

    if (tipoVisitante.value === "alumno") {
        if (matriculaVal === "") {
            showModal(
                "Campo requerido",
                "La matrícula es obligatoria para alumnos.",
            );
            return;
        }
        if (!regexMatricula.test(matriculaVal)) {
            showModal("Formato incorrecto", "La matrícula no es válida.");
            return;
        }
    }

    if (nombreVal.length < 3) {
        showModal("Campo requerido", "Por favor ingresa tu nombre completo.");
        return;
    }

    if (eventoVal === "") {
        showModal(
            "Campo requerido",
            "Por favor selecciona un evento de la lista.",
        );
        return;
    }

    console.log("Formulario válido, enviando...");
    form.submit();
});
