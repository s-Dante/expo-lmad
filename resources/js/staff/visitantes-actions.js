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

/*---VALIDACIONES ---*/
const form = document.getElementById("form-visitante");

form.addEventListener("submit", (e) => {
    e.preventDefault();

    const tipoVisitante = document.querySelector('input[name="tipo_visitante"]:checked');
    const matriculaVal = document.getElementById("matricula").value.trim();
    const nombreVal = document.getElementById("nombre").value.trim();
    const generoVal = document.getElementById("genero").value;
    
    const regexMatricula = /^\d{7}$/;

    if (!tipoVisitante) {
        showModal("Error", "Por favor selecciona si eres Alumno o Externo.");
        return;
    }

    if (tipoVisitante.value === "alumno") {
        if (matriculaVal === "") {
            showModal("Campo requerido", "La matrícula es obligatoria para alumnos.");
            return;
        }
        if (!regexMatricula.test(matriculaVal)) {
            showModal("Formato incorrecto", "La matrícula debe tener exactamente 7 números.");
            return;
        }
    }

    if (nombreVal.length < 3) {
        showModal("Campo requerido", "Por favor ingresa tu nombre completo.");
        return;
    }

    if (generoVal === "") {
        showModal("Campo requerido", "Por favor selecciona un género.");
        return;
    }

    form.submit();
});