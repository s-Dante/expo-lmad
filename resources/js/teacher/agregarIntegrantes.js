

document.addEventListener('DOMContentLoaded', () => {
    const inputIntegrantes = document.getElementById('num-integrantes');
    const contenedorAlumnos = document.getElementById('contenedor-alumnos');

  inputIntegrantes.addEventListener('input', () => {
    const cantidad = parseInt(inputIntegrantes.value);
    contenedorAlumnos.innerHTML = '';

    if (cantidad > 0) {
        for (let i = 1; i <= cantidad; i++) {
            
            if (i === 1) {
                const labelLider = document.createElement('h3');
                labelLider.className = 'seccion-titulo';
                labelLider.innerText = 'Líder de Equipo';
                contenedorAlumnos.appendChild(labelLider);
            }

            if (i === 2) {
                const labelInteg = document.createElement('h3');
                labelInteg.className = 'seccion-titulo';
                labelInteg.innerText = 'Integrantes';
                contenedorAlumnos.appendChild(labelInteg);
            }

            const fila = document.createElement('div');
            fila.className = 'fila-alumno';

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

    
        contenedorAlumnos.addEventListener('keyup', async (e) => {
            if (e.target.matches('.matricula')) {
                const inputMatricula = e.target;
                const matricula = inputMatricula.value;

                const fila = inputMatricula.closest('.fila-alumno');
                const inputNombre = fila.querySelector('.nombre');

                // Solo buscamos si tiene exactamente o más de 7 (ajusta según tus matrículas)
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
                    }
                } else {
                    inputNombre.value = '';
                }
            }
        });
});