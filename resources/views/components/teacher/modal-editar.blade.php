<div id="modal-edicion" class="modal-overlay">
    <div class="modal-content">
        <button class="close-modal" onclick="cerrarModal()">&times;</button>

        <h1 class="text-main">EDICIÓN DE EXPOSITORES</h1>

        <article class="expo-card">
            <form>
                <h2 class="card-title" id="modal-titulo">ADADAT</h2>

                <div class="datos-box">
                    <div class="fila-full">
                        <label>Materia:</label>
                        <select class="input-c" id="modal-materia">
                            <option value="" disabled>Selecciona una materia</option>
                            @foreach ($materias as $materia)
                                <option value="{{ $materia->id }}" data-plan="{{ $materia->planAcademico->nombre }}"
                                    data-semestre="{{ $materia->semestre }}">
                                    {{ $materia->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="fila-flex">
                        <div class="item">
                            <label>Plan:</label>
                            <input type="text" id="modal-plan_academico" readonly>
                        </div>
                        <div class="item">
                            <label>Semestre:</label>
                            <input type="text" id="modal-semestre" readonly>
                        </div>
                    </div>

                    <div class="fila-full">
                        <label>Número de integrantes:</label>
                        <input type="number" name="num_integrantes" id="modal-num-integrantes">
                    </div>
                </div>

                <div class="alumnos-box" id="contenedor-alumnos">

                    <div class="fila-alumno">
                        <div class="item">
                            <label>Matrícula:</label>
                            <input type="text" class="input-c matricula" value="" readonly>
                        </div>
                        <div class="item">
                            <label>Alumno:</label>
                            <input type="text" class="input-c nombre" value="" readonly>
                        </div>
                    </div>

                </div>

                <button type="button" class="btn-save">Guardar cambios</button>

            </form>
        </article>
    </div>
</div>