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
        $proyectos = Proyecto::take(3)->get();

        foreach ($proyectos as $proyecto) {
            // Portada
            MultimediaProyecto::factory()
                ->portada()
                ->create([
                    'proyecto_id' => $proyecto->id,
                    'tipo' => 'imagen',
                ]);

            // Multimedia adicional
            MultimediaProyecto::factory()
                ->count(3)
                ->create([
                    'proyecto_id' => $proyecto->id,
                ]);
        }
    }
}
