<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ProgramaAcademico;

class ProgramaAcademicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programas = [
            [
                'nombre' => 'Licenciatura en Actuaría',
                'abreviatura' => 'LA',
                'descripcion' => 'Definir',
                'estatus' => true
            ],
            [
                'nombre' => 'Licenciatura en Ciencias Computacionales',
                'abreviatura' => 'LCC',
                'descripcion' => 'Definir',
                'estatus' => true
            ],
            [
                'nombre' => 'Licenciatura en Física',
                'abreviatura' => 'LF',
                'descripcion' => 'Definir',
                'estatus' => true
            ],
            [
                'nombre' => 'Licenciatura en Matemáticas',
                'abreviatura' => 'LM',
                'descripcion' => 'Definir',
                'estatus' => true
            ],
            [
                'nombre' => 'Licenciatura en Multimedia y Animación Digital',
                'abreviatura' => 'LMAD',
                'descripcion' => 'Definir',
                'estatus' => true
            ],
            [
                'nombre' => 'Licenciatura en Seguridad en Tecnologías de la Información',
                'abreviatura' => 'LSTI',
                'descripcion' => 'Definir',
                'estatus' => true
            ],
        ];


        foreach ($programas as $programa) {
            ProgramaAcademico::firstOrCreate(
                ['abreviatura' => $programa['abreviatura']],
                $programa
            );
        }
    }
}
