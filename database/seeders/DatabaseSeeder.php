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

// Factories
use Database\Factories\ProgramaAcademicoFactory;
use Database\Factories\PlanAcademicoFactory;
use Database\Factories\MateriaFactory;
use Database\Factories\EstudianteFactory;
use Database\Factories\ProfesorFactory;

// Models
use App\Models\ProgramaAcademico;
use App\Models\PlanAcademico;
use App\Models\Materia;
use App\Models\Estudiante;
use App\Models\Profesor;


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
        }
    }
}

