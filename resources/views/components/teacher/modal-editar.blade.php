<div id="modal-edicion" class="modal-overlay">
    <div class="modal-content">
        <button class="close-modal" onclick="cerrarModal()">&times;</button>

        <h1 class="text-main">EDICIÓN DE EXPOSITORES</h1>

        <article class="expo-card">
            <form>
                <h2 class="card-title">ADADAT</h2>

                <div class="datos-box">
                    <div class="fila-full">
                        <label>Materia:</label>
                        <select class="input-c">
                            <option>Administración de Datos</option>
                        </select>
                    </div>

                    <div class="fila-flex">
                        <div class="item">
                            <label>Plan:</label>
                            <select class="input-c corto">
                                <option>401</option>
                            </select>
                        </div>
                        <div class="item">
                            <label>Semestre:</label>
                            <select class="input-c corto">
                                <option>6</option>
                            </select>
                        </div>
                    </div>

                    <div class="fila-full">
                        <label>Número de integrantes:</label>
                        <select class="input-c corto">
                            <option>2</option>
                        </select>
                    </div>
                </div>

                <div class="alumnos-box" id="contenedor-alumnos">

                    <div class="fila-alumno">
                        <div class="item">
                            <label>Matrícula:</label>
                            <input type="text" class="input-c matricula" value="2084689">
                        </div>
                        <div class="item">
                            <label>Alumno:</label>
                            <input type="text" class="input-c nombre" value="alumno1234">
                        </div>
                    </div>
                    <div class="fila-alumno">
                        <div class="item">
                            <label>Matrícula:</label>
                            <input type="text" class="input-c matricula" value="2084689">
                        </div>
                        <div class="item">
                            <label>Alumno:</label>
                            <input type="text" class="input-c nombre" value="alumno1234">
                        </div>
                    </div>
                    <div class="fila-alumno">
                        <div class="item">
                            <label>Matrícula:</label>
                            <input type="text" class="input-c matricula" value="2084689">
                        </div>
                        <div class="item">
                            <label>Alumno:</label>
                            <input type="text" class="input-c nombre" value="alumno1234">
                        </div>
                    </div>
                    <div class="fila-alumno">
                        <div class="item">
                            <label>Matrícula:</label>
                            <input type="text" class="input-c matricula" value="2084689">
                        </div>
                        <div class="item">
                            <label>Alumno:</label>
                            <input type="text" class="input-c nombre" value="alumno1234">
                        </div>
                    </div>

                </div>

                <button type="button" class="btn-save">Guardar cambios</button>

            </form>
        </article>
    </div>
</div>