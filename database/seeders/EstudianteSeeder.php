<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Estudiante;
use App\Models\User;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usar el factory para crear estudiantes de prueba
        Estudiante::factory(10)->create();

        // Uno manual para pruebas específicas
        Estudiante::factory()->create([
            'matricula' => '1000000',
            'nombre' => 'Estudiante',
            'apellido_paterno' => 'De Prueba',
            'semestre' => 8,
        ]);
    }
}
