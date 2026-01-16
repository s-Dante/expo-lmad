<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Materia;
use App\Models\PlanAcademico;

class MateriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plan = PlanAcademico::where('nombre', 'Plan 420')->first(); //Quiza deberia de ser lo de Plan ### si se queda lo de la palabra plan

        if (!$plan) {
            return;
        }

        $materias = [ //<- Dejar todas las materias que tiene la carrera
            [
                'clave' => 'MAT101',
                'nombre' => 'Matemáticas I',
                'abreviatura' => 'MAT I',
                'creditos' => 8,
                'semestre' => 1,
            ],
            [
                'clave' => 'PRO102',
                'nombre' => 'Programación I',
                'abreviatura' => 'PRO I',
                'creditos' => 8,
                'semestre' => 1,
            ],
        ];

        foreach ($materias as $materia) {
            Materia::firstOrCreate(
                [
                    'clave' => $materia['clave'],
                    'plan_academico_id' => $plan->id,
                ],
                $materia
            );
        }

        
    }
}
