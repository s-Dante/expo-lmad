import { showModal } from "../components/alerts.js";

const inputIntegrantes = document.getElementById("num-integrantes");
const contenedorAlumnos = document.getElementById("contenedor-alumnos");

inputIntegrantes.addEventListener("input", () => {
    const cantidad = parseInt(inputIntegrantes.value);
    contenedorAlumnos.innerHTML = "";

    if (cantidad > 0) {
        for (let i = 1; i <= cantidad; i++) {
            if (i === 1) {
                const labelLider = document.createElement("h3");
                labelLider.className = "seccion-titulo";
                labelLider.innerText = "Líder de Equipo";
                contenedorAlumnos.appendChild(labelLider);
            }

            if (i === 2) {
                const labelInteg = document.createElement("h3");
                labelInteg.className = "seccion-titulo";
                labelInteg.innerText = "Integrantes";
                contenedorAlumnos.appendChild(labelInteg);
            }

            const fila = document.createElement("div");
            fila.className = "fila-alumno";

            fila.innerHTML = `
                <div class="item">
                    <label>Matrícula:</label>
                    <input type="text" name="estudiantes[${i - 1}][matricula]" class="input-c matricula">
                </div>
                <div class="item">
                    <label>Alumno:</label>
                    <input type="text" name="estudiantes[${i - 1}][nombre]" class="input-c nombre" readonly>
                </div>
            `;
            contenedorAlumnos.appendChild(fila);
        }
    }
});

contenedorAlumnos.addEventListener("keyup", async (e) => {
    if (e.target.matches(".matricula")) {
        const inputMatricula = e.target;
        const matricula = inputMatricula.value;

        const fila = inputMatricula.closest(".fila-alumno");
        const inputNombre = fila.querySelector(".nombre");

        // Solo buscamos si tiene exactamente o más de 7 (ajusta según tus matrículas)
        if (matricula.length >= 7) {
            inputNombre.value = "Buscando...";

            try {
                const response = await fetch(
                    `/api/buscar-estudiante/${matricula}`,
                );
                const data = await response.json();

                if (data.success) {
                    inputNombre.value = data.nombre;
                } else {
                    inputNombre.value = "No encontrado";
                }
            } catch (error) {
                inputNombre.value = "Error de conexión";
            }
        } else {
            inputNombre.value = "";
        }
    }
});

const form = document.getElementById("form-registro");
const selectMateria = document.getElementById("materia_id");

form.addEventListener("submit", (e) => {
    e.preventDefault();

    if (!selectMateria.value) {
        showModal(
            "Datos inválidos",
            "Por favor, selecciona una materia para el proyecto.",
        );
        return;
    }

    const cantidad = parseInt(inputIntegrantes.value);
    if (isNaN(cantidad) || cantidad <= 0) {
        showModal(
            "Datos inválidos",
            "Debes ingresar al menos 1 integrante para registrar el proyecto.",
        );
        return;
    }

    const inputsMatricula = document.querySelectorAll(".matricula");
    let todasLlenas = true;

    const regexMatricula = /^\d{7}$/;

    for (let i = 0; i < inputsMatricula.length; i++) {
        const valor = inputsMatricula[i].value.trim();

        if (valor === "") {
            showModal(
                "Campo requerido",
                `La matrícula del integrante #${i + 1} está vacía.`,
            );
            return;
        }

        if (!regexMatricula.test(valor)) {
            showModal(
                "Formato inválido",
                `La matrícula del integrante #${i + 1} debe tener exactamente 7 números (ej. 1928374).`,
            );
            return;
        }
    }

    if (!todasLlenas) return;

    form.submit();
});
