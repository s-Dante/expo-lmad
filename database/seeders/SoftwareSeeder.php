<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Software;

class SoftwareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $softwares = [
            ['nombre' => 'Blender', 'descripcion' => 'Modelado y animación 3D'],
            ['nombre' => 'Unity', 'descripcion' => 'Motor de videojuegos'],
            ['nombre' => 'Unreal Engine', 'descripcion' => 'Motor de videojuegos'],
            ['nombre' => 'After Effects', 'descripcion' => 'Postproducción'],
            ['nombre' => 'Photoshop', 'descripcion' => 'Edición de imagen'],
            ['nombre' => 'Premiere Pro', 'descripcion' => 'Edición de video'],
            ['nombre' => 'Maya', 'descripcion' => 'Modelado 3D'],
            ['nombre' => 'Visual Studio Code', 'descripcion' => 'Editor de código'],
            ['nombre' => 'Figma', 'descripcion' => 'Diseño de interfaces'],
        ];

        foreach ($softwares as $software) {
            Software::firstOrCreate(
                ['nombre' => $software['nombre']],
                $software
            );
        }
    }
}
