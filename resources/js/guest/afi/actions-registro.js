import { show_hide_list } from '../../components/show-hide-elements.js';

document.addEventListener("DOMContentLoaded", () => {
    const selectFacultad = document.getElementById("select-facultad");
    const selectCarrera = document.getElementById("select-carrera");
    const containerCarrera = document.getElementById("container-carrera");
    const containerDependencia = document.getElementById("container-dependencia");
    const inputDependencia = document.getElementById("input-dependencia");

    if (containerDependencia && containerDependencia.classList.contains("d-none")) {
        containerDependencia.classList.remove("d-none");
        containerDependencia.style.display = "none";
    }

    if (selectFacultad && selectCarrera) {
        selectFacultad.addEventListener("change", function () {
            
            if (this.value === "FCFM") {
                selectCarrera.disabled = false;
            } else {
                selectCarrera.disabled = true; 
                selectCarrera.value = "";
            }

            if (this.value === "NP") {
                show_hide_list([containerCarrera], 'none');
                show_hide_list([containerDependencia], 'block');
            } else {
                show_hide_list([containerCarrera], 'block');
                show_hide_list([containerDependencia], 'none');
                if (inputDependencia) inputDependencia.value = ""; 
            }
        });
    }
});
