<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>EXPO LMAD - Maestros</title>
    @vite(['resources/css/teacher/registro-expositores.css'])
    @vite(['resources/js/teacher/agregarIntegrantes.js'])
    @vite(['resources/js/teacher/mostrarInfoMateria.js'])
</head>

<body>
    <x-sidebar />
    <main class="main-content">
        <h1 class="text-main">REGISTRO DE EXPOSITORES</h1>

        <section class="expo-card">

            <form method="post" action="{{ route('teacher.cargar-proyecto') }}" class="expo-form">
                @csrf

                <input type="hidden" name="profesor_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="periodo_semestral" value="Enero - Junio 2026">

                <h2 class="card-title">ADADAT</h2>

                <div class="datos-box">
                    <div class="fila-full">
                        <label>Materia:</label>
                        <select class="input-c" name="materia_id" id="materia_id">
                            <option value="" disabled selected>Selecciona una materia</option>
                            @foreach ($materiasProfesor as $materia)
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
                            <input type="text" class="input-c" id="in_planAcademico" readonly>
                        </div>
                        <div class="item">
                            <label>Semestre:</label>
                            <input type="text" class="input-c" id="in_semestre" readonly>
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
                            <input type="text" class="input-c matricula" name="estudiantes[0][matricula]">
                        </div>
                        <div class="item">
                            <label>Alumno:</label>
                            <input type="text" class="input-c nombre" name="estudiantes[0][nombre]" readonly>
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn-save">Guardar</button>

            </form>

        </section>

    </main>



</body>