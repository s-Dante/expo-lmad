<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Estudiante;
use App\Models\AutorProyecto;
use App\Models\Proyecto;

class AutorProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los proyectos y estudiantes
        $proyectos = Proyecto::all();
        $estudiantes = Estudiante::all();

        if ($proyectos->isEmpty() || $estudiantes->isEmpty()) {
            return;
        }

        foreach ($proyectos as $proyecto) {
            $tamañoEquipo = fake()->boolean(30) ? 1 : rand(2, 4);

            $equipo = $estudiantes->random(min($tamañoEquipo, $estudiantes->count()));


            foreach ($equipo as $index => $estudiante) {

                $esLider = ($index === 0);

                $proyecto->autores()->syncWithoutDetaching([
                    $estudiante->id => [
                        'es_lider' => $esLider,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]);
            }
        }
        
        // --- CASO ESPECIAL FORZADO (Opcional) ---
        // Para asegurar que tengas un alumno "Super Star" con 3 proyectos para pruebas
        /*
        $alumnoStar = Estudiante::first();
        $proyectosExtra = Proyecto::whereDoesntHave('autores', function($q) use ($alumnoStar) {
            $q->where('estudiante_id', $alumnoStar->id);
        })->take(2)->get();
        
        foreach($proyectosExtra as $proj) {
            $proj->autores()->attach($alumnoStar->id, ['es_lider' => false]);
        }
        */
    }
}
