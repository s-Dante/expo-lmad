<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // PRODUCCIÓN: solo usuarios administrativos
        // ==========================================
        // Para datos reales (programas, planes, materias, profesores, estudiantes)
        // usa el panel de Admin → Importar con los archivos Excel del padrón.
        $this->call([
            UserSeeder::class,
        ]);

        // ==========================================
        // DESARROLLO LOCAL: datos de prueba completos
        // ==========================================
        if (App::environment('local')) {
            $this->call([
                // Catálogos base
                SoftwareSeeder::class,
                ProgramaAcademicoSeeder::class,
                PlanAcademicoSeeder::class,
                CategoriaSeeder::class,
                MateriaSeeder::class,

                // Personas
                EstudianteSeeder::class,
                ProfesorSeeder::class,

                // Actores externos
                ConferencistaSeeder::class,
                PatrocinadorSeeder::class,

                // Proyectos
                ProyectoSeeder::class,
                AutorProyectoSeeder::class,
                MultimediaProyectoSeeder::class,

                // Eventos
                EventoSeeder::class,
                VisitanteSeeder::class,
                AsistenciaGeneralSeeder::class,
            ]);
        }
    }
}
