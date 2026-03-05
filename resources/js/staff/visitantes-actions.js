const radioAlumno = document.getElementById("alumno");
const radioExterno = document.getElementById("externo");
const containerMatricula = document.getElementById("container-matricula");
const inputMatricula = document.getElementById("matricula");

function toggleMatricula() {
    if (radioExterno.checked) {
       containerMatricula.classList.add("hidden-field");
        inputMatricula.required = false;
        inputMatricula.value = "";
    } else {
       containerMatricula.classList.remove("hidden-field");
        inputMatricula.required = true;
    }
}

radioAlumno.addEventListener("change", toggleMatricula);
radioExterno.addEventListener("change", toggleMatricula);

toggleMatricula();
