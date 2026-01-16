<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Seeders
use Database\Seeders\ProgramaAcademicoSeeder;
use Database\Seeders\PlanAcademicoSeeder;
use Database\Seeders\MateriaSeeder;
use Database\Seeders\EstudianteSeeder;
use Database\Seeders\ProfesorSeeder;
use Database\Seeders\ProyectoSeeder;
use Database\Seeders\AutorProyectoSeeder;
use Database\Seeders\MultimediaProyectoSeeder;
use Database\Seeders\SoftwareSeeder;

// Factories
use Database\Factories\ProgramaAcademicoFactory;
use Database\Factories\PlanAcademicoFactory;
use Database\Factories\MateriaFactory;
use Database\Factories\EstudianteFactory;
use Database\Factories\ProfesorFactory;
use Database\Factories\ProyectoFactory;
use Database\Factories\AutorProyectoFactory;
use Database\Factories\MultimediaProyectoFactory;
use Database\Factories\SoftwareFactory;

// Models
use App\Models\ProgramaAcademico;
use App\Models\PlanAcademico;
use App\Models\Materia;
use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\Proyecto;
use App\Models\AutorProyecto;
use App\Models\MultimediaProyecto;
use App\Models\Software;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // CATÁLOGOS BASE
        // =========================
        $this->call([
            ProgramaAcademicoSeeder::class,
            PlanAcademicoSeeder::class,
            MateriaSeeder::class,
            SoftwareSeeder::class,
        ]);

        // =========================
        // USUARIOS
        // =========================
        if(app()->environment('local')) {
            // =========================
            // SUPER ADMINS
            // =========================
            User::factory()
                ->superAdmin()
                ->count(3)
                ->create();

            // =========================
            // ADMIN BASE
            // =========================
            User::factory()
                ->admin()
                ->create([
                    'email' => 'admin@expo-lmad.mx',
                ]);

            // =========================
            // STAFF BASE
            // =========================
            User::factory()
                ->staff()
                ->count(2)
                ->create();

            // =========================
            // PROFESORES
            // =========================
            Profesor::factory()
                ->count(5)
                ->create()
                ->each(function ($profesor) {
                    $usuario = User::factory()
                        ->profesor()
                        ->create([
                            'llave_acceso' => $profesor->numero_empleado,
                        ]);

                    $profesor->update([
                        'usuario_id' => $usuario->id,
                    ]);
                });

            // =========================
            // ESTUDIANTES CON ACCESO
            // =========================
            Estudiante::factory()
                ->count(10)
                ->create()
                ->each(function ($estudiante) {
                    $usuario = User::factory()
                        ->estudiante()
                        ->create([
                            'llave_acceso' => $estudiante->matricula,
                        ]);

                    $estudiante->update([
                        'usuario_id' => $usuario->id,
                    ]);
                });

            // =========================
            // ESTUDIANTES SIN ACCESO
            // =========================
            Estudiante::factory()
                ->count(30)
                ->create([
                    'usuario_id' => null,
                ]);


            // =========================
            // PROYECTOS
            // =========================
            Proyecto::factory()
                ->count(10)
                ->create();


            // =========================
            // RELACIONES AUTOR - PROYECTO
            // =========================
            $this->call([
                AutorProyectoSeeder::class,
            ]);

            // =========================
            // MULTIMEDIA PROYECTOS
            // =========================
            $this->call([
                MultimediaProyectoSeeder::class,
            ]);
        }
    }
}

