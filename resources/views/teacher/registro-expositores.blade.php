<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>EXPO LMAD - Maestros</title>
    @vite(['resources/css/teacher/registro-expositores.css'])

    @vite(['resources/js/teacher/agregarIntegrantes.js'])
</head>

<body>
    <x-sidebar />
    <main class="main-content">
        <h1 class="text-main">REGISTRO DE EXPOSITORES</h1>

        <section class="expo-card">

            <form class="expo-form">
                <h2 class="card-title">ADADAT</h2>

                <div class="datos-box">
                    <div class="fila-full">
                        <label>Materia:</label>
                        <select class="input-c"></select>
                    </div>

                    <div class="fila-flex">
                        <div class="item">
                            <label>Plan:</label>
                            <input type="text" class="input-c">
                        </div>
                        <div class="item">
                            <label>Semestre:</label>
                            <input type="text" class="input-c">
                        </div>
                    </div>

                    <div class="fila-full">
                        <label>Número de integrantes:</label>
                        <input type="number" id="num-integrantes" class="input-c corto" min="1" max="10" value="1">
                    </div>
                </div>

                <div class="alumnos-box" id="contenedor-alumnos">

                    <div class="fila-alumno">
                        <div class="item">
                            <label>Matrícula:</label>
                            <input type="text" class="input-c matricula">
                        </div>
                        <div class="item">
                            <label>Alumno:</label>
                            <input type="text" class="input-c nombre">
                        </div>
                    </div>

                </div>

                <button class="btn-save">Guardar cambios</button>

            </form>

        </section>

    </main>

</body>