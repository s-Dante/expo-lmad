<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proyecto;
use App\Models\Software;
use App\Models\Profesor;

class ProyectoSeeder extends Seeder
{
    public function run(): void
    {
        $profesores = Profesor::has('materias')->with('materias')->get();

        if ($profesores->isEmpty()) {
            $this->command->info('No hay profesores con materias asignadas. Saltando ProyectoSeeder.');
            return;
        }

        $softwares = Software::all();

        foreach ($profesores as $profesor) {
            for ($i = 0; $i < 10; $i++) {
                $materia = $profesor->materias->random();

                $proyecto = Proyecto::factory()->create([
                    'profesor_id' => $profesor->id,
                    'materia_id' => $materia->id,
                    'periodo_semestral' => 'Enero - Junio 2026',
                    'estatus' => 'aprobado',
                ]);
                
                if ($softwares->isNotEmpty()) {
                    $proyecto->softwares()->attach(
                        $softwares->random(rand(1, 3))->pluck('id')
                    );
                }
            }
        }
    }
}