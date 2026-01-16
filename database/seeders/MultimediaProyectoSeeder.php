<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Proyecto;
use App\Models\MultimediaProyecto;

class MultimediaProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proyectos = Proyecto::all();

        if ($proyectos->isEmpty()) {
            return;
        }

        foreach ($proyectos as $proyecto) {
            MultimediaProyecto::factory()
                ->portada()
                ->create([
                    'proyecto_id' => $proyecto->id,
                ]);

            MultimediaProyecto::factory()
                ->count(rand(2, 5))
                ->create([
                    'proyecto_id' => $proyecto->id,
                    'es_portada' => false,
                ]);
        }
    }
}
