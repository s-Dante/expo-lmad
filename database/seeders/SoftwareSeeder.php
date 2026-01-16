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
            [
                'software_name' => 'Blender',
                'software_description' => 'Modelado y animación 3D',
            ],
            [
                'software_name' => 'Unity',
                'software_description' => 'Motor de videojuegos',
            ],
            [
                'software_name' => 'Unreal Engine',
                'software_description' => 'Motor de videojuegos',
            ],
            [
                'software_name' => 'After Effects',
                'software_description' => 'Postproducción y motion graphics',
            ],
            [
                'software_name' => 'Photoshop',
                'software_description' => 'Edición de imagen',
            ],
            [
                'software_name' => 'Premiere Pro',
                'software_description' => 'Edición de video',
            ],
            [
                'software_name' => 'Maya',
                'software_description' => 'Modelado y animación 3D',
            ],
        ];

        foreach ($softwares as $software) {
            Software::firstOrCreate(
                ['software_name' => $software['software_name']],
                $software
            );
        }
    }
}
