<?php

namespace Database\Seeders;

use App\Models\Proyecto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Estudiante;
use App\Models\AutorProyecto;

class AutorProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proyecto = Proyecto::first();

        if(!$proyecto) {
           return;
        }

        $estudiantes = Estudiante::take(3)->get();

        if ($estudiantes->isEmpty()) {
            return;
        }

        foreach ($estudiantes as $index => $estudiante) {
            $proyecto->autores()->syncWithoutDetaching([
                $estudiante->id => [
                    'es_lider' => $index === 0,
                ]
            ]);
        }
    }
}
