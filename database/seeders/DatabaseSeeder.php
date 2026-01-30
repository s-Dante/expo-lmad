<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

// Seeders
use Database\Seeders\ProgramaAcademicoSeeder;
use Database\Seeders\PlanAcademicoSeeder;
use Database\Seeders\CategoriaSeeder;
use Database\Seeders\MateriaSeeder;
use Database\Seeders\EstudianteSeeder;
use Database\Seeders\ProfesorSeeder;
use Database\Seeders\ProyectoSeeder;
use Database\Seeders\AutorProyectoSeeder;
use Database\Seeders\MultimediaProyectoSeeder;
use Database\Seeders\SoftwareSeeder;
use Database\Seeders\SoftwarePorProyectoSeeder;
use Database\Seeders\AsistenciaGeneralSeeder;
use Database\Seeders\ConferenciaSeeder;

// Factories
use Database\Factories\ProgramaAcademicoFactory;
use Database\Factories\PlanAcademicoFactory;
use Database\Factories\CategoriaFactory;
use Database\Factories\MateriaFactory;
use Database\Factories\EstudianteFactory;
use Database\Factories\ProfesorFactory;
use Database\Factories\ProyectoFactory;
use Database\Factories\AutorProyectoFactory;
use Database\Factories\MultimediaProyectoFactory;
use Database\Factories\SoftwareFactory;
use Database\Factories\SoftwarePorProyectoFactory;
use Database\Factories\AsistenciaGeneralFactory;
use Database\Factories\ConferenciaFactory;

// Models
use App\Models\ProgramaAcademico;
use App\Models\PlanAcademico;
use App\Models\Categoria;
use App\Models\Materia;
use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\Proyecto;
use App\Models\AutorProyecto;
use App\Models\MultimediaProyecto;
use App\Models\Software;
use App\Models\SoftwarePorProyecto;
use App\Models\AsistenciaGeneral;
use App\Models\Conferencia;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. INFRAESTRUCTURA (CATÁLOGOS) - GLOBAL
        // ==========================================
        $this->call([
            SoftwareSeeder::class,
            ProgramaAcademicoSeeder::class,
            PlanAcademicoSeeder::class,
            CategoriaSeeder::class,
            MateriaSeeder::class,
        ]);

        // ==========================================
        // 2. MOCK DATA - SOLO DESARROLLO (LOCAL)
        // ==========================================
        if (App::environment('local')) {
            $this->call([
                // -- Personas Base --
                EstudianteSeeder::class, // Padrón Alumnos
                ProfesorSeeder::class,   // Padrón Profes (con materias asignadas)
                AsistenciaGeneralSeeder::class, // Asistencias Generales (QR)
                
                // -- Actores Externos --
                ConferencistaSeeder::class, // Speakers
                PatrocinadorSeeder::class,  // Empresas y Representantes (Visitantes tipo sponsor)

                // -- Operación Core: Proyectos --
                ProyectoSeeder::class,           // Proyectos (Profesor + Materia + Softwares)
                AutorProyectoSeeder::class,      // Equipos (Estudiantes + Proyecto)
                MultimediaProyectoSeeder::class, // Galería

                // -- Operación Core: Eventos --
                EventoSeeder::class,     // Agenda (Eventos + Conferencistas)
                VisitanteSeeder::class,  // Audiencia general y Asistencias
            ]);
        }

        // ==========================================
        // 3. ACCESOS (USUARIOS) - AL FINAL
        // ==========================================
        $this->call([
            UserSeeder::class, // Crea admins y asigna cuentas a Alumnos/Profes del padrón
        ]);
    }
}
