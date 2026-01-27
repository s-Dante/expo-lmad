document.addEventListener('DOMContentLoaded', () => {
    const inputIntegrantes = document.getElementById('num-integrantes');
    const contenedorAlumnos = document.getElementById('contenedor-alumnos');

    inputIntegrantes.addEventListener('input', () => {
        const cantidad = parseInt(inputIntegrantes.value);
        
        contenedorAlumnos.innerHTML = '';

        if (cantidad > 0) {
            for (let i = 1; i <= cantidad; i++) {
                const fila = document.createElement('div');
                fila.className = 'fila-alumno';
                
                fila.innerHTML = `
                    <div class="item">
                        <label>Matrícula:</label>
                        <input type="text"  name="estudiantes[${i-1}][matricula]" class="input-c matricula">
                    </div>
                    <div class="item">
                        <label>Alumno:</label>
                        <input type="text"  name="estudiantes[${i-1}][nombre]" class="input-c nombre">
                    </div>
                `;
                contenedorAlumnos.appendChild(fila);
            }
        }
    });
});