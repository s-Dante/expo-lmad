
window.abrirModal = function (button) {
    const modal = document.getElementById('modal-edicion');

    const card = button.closest('.card-project');
    const token = card.dataset.proyectoToken;

    if (modal) {
        modal.style.display = 'flex';
        buscarProyectoModal(token);
    }

}

// Función para buscar proyecto por token y llenar el modal
async function buscarProyectoModal(token) {
    try {
        const response = await fetch(`/api/obtener-proyecto-token/${token}`);
        const result = await response.json();

        if (result.success && result.data) {

            const proyecto = result.data;
            //console.log("Proyecto encontrado:", proyecto);
            const tokenInput = document.getElementById('hidden_token');
            if (tokenInput) tokenInput.value = token;

            const tituloDisplay = document.querySelector('.card-title');
            if (tituloDisplay) tituloDisplay.innerText = proyecto.titulo || 'Sin título aún';

            const campoMateria = document.getElementById('modal-materia');
            if (campoMateria) campoMateria.value = proyecto.materia_id;

            const campoPlanAcademico = document.getElementById('modal-plan_academico');
            if (campoPlanAcademico && proyecto.materia) {
                campoPlanAcademico.value = proyecto.materia.plan_academico.nombre;
            }

            const campoSemestre = document.getElementById('modal-semestre');
            if (campoSemestre && proyecto.materia) {
                campoSemestre.value = proyecto.materia.semestre;
            }

            const campoPeriodo = document.getElementById('modal-periodo-semestral');
            if(campoPeriodo) campoPeriodo.value = proyecto.periodo_semestral;

            // 4. Número de integrantes
            const numIntegrantes = proyecto.autores.length;
            const campoIntegrantes = document.getElementById('modal-num-integrantes');
            if (campoIntegrantes) campoIntegrantes.value = numIntegrantes;

            // 5. Contenedor de Alumnos
            const contenedor = document.getElementById('contenedor-alumnos');
            if (contenedor) {
                contenedor.innerHTML = '';

                proyecto.autores.forEach((autor, index) => {
                    const fila = document.createElement('div');
                    fila.className = 'fila-alumno';
                    fila.innerHTML = `
                        <div class="item">
                            <label>Matrícula:</label>
                            <input type="text" class="input-c matricula" 
                                   name="estudiantes[${index}][matricula]" 
                                   value="${autor.matricula}">
                        </div>
                        <div class="item">
                            <label>Alumno:</label>
                            <input type="text" class="input-c nombre"  
                                   value="${autor.nombre} ${autor.apellido_paterno} ${autor.apellido_materno}" 
                                   readonly>
                        </div>
                    `;
                    contenedor.appendChild(fila);
                });
            }

        } else {
            alert("No se encontró el proyecto o el arreglo de datos está vacío");
        }
    } catch (error) {
        console.error("Error detallado:", error);
        alert("Error de conexión al obtener los datos");
    }
}

// Lógica para actualizar Plan y Semestre al cambiar la materia
document.getElementById('modal-materia').addEventListener('change', function () {
    const opcionSeleccionada = this.options[this.selectedIndex];

    const planAcademico = opcionSeleccionada.getAttribute('data-plan');
    const semestre = opcionSeleccionada.getAttribute('data-semestre');
    const planInput = document.getElementById('modal-plan_academico');
    const semestreInput = document.getElementById('modal-semestre');

    planInput.value = planAcademico;
    semestreInput.value = semestre;
});



window.cerrarModal = function () {
    const modal = document.getElementById('modal-edicion');
    if (modal) {
        modal.style.display = 'none';
    }
}

window.onclick = function (event) {
    const modal = document.getElementById('modal-edicion');
    if (event.target == modal) {
        window.cerrarModal();
    }
}
// Lógica para ajustar filas de alumnos según número de integrantes
document.getElementById('modal-num-integrantes').addEventListener('change', function () {
    const contenedor = document.getElementById('contenedor-alumnos');
    const numeroDeseado = parseInt(this.value);
    const filasActuales = contenedor.querySelectorAll('.fila-alumno');
    const cantidadActual = filasActuales.length;

    if (numeroDeseado > cantidadActual) {
        for (let i = cantidadActual; i < numeroDeseado; i++) {
            const fila = document.createElement('div');
            fila.className = 'fila-alumno';
            fila.innerHTML = `
                <div class="item">
                    <label>Matrícula:</label>
                    <input type="text" class="input-c matricula" 
                           name="estudiantes[${i}][matricula]" 
                           placeholder="Ingresa la matrícula">
                </div>
                <div class="item">
                    <label>Alumno:</label>
                    <input type="text" class="input-c nombre" 
                           name="estudiantes[${i}][nombre]" 
                           placeholder="Nombre completo" readonly>
                </div>
            `;
            contenedor.appendChild(fila);

            // Aquí podrías re-vincular tu evento de búsqueda de matrícula si es necesario
        }
    } else if (numeroDeseado < cantidadActual) {

        for (let i = cantidadActual; i > numeroDeseado; i--) {
            contenedor.lastElementChild.remove();
        }
    }
});

// Lógica de búsqueda de estudiante por matrícula en el modal
const contenedorAlumnosModal = document.getElementById('contenedor-alumnos');
if (contenedorAlumnosModal) {
    contenedorAlumnosModal.addEventListener('keyup', async (e) => {
        if (e.target.matches('.matricula')) {
            const inputMatricula = e.target;
            const matricula = inputMatricula.value;

            const fila = inputMatricula.closest('.fila-alumno');
            const inputNombre = fila.querySelector('.nombre');

            if (matricula.length >= 7) {
                inputNombre.value = 'Buscando...';

                try {
                    const response = await fetch(`/api/buscar-estudiante/${matricula}`);
                    const data = await response.json();

                    if (data.success) {


                        inputNombre.value = data.nombre;
                    } else {
                        inputNombre.value = 'No encontrado';
                    }
                } catch (error) {
                    inputNombre.value = 'Error de conexión';
                    console.error("Error en fetch:", error);
                }
            } else {
                inputNombre.value = '';
            }
        }
    });
}