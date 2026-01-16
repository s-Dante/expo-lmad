<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PlanAcademico;
use App\Models\ProgramaAcademico;

class PlanAcademicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lmad = ProgramaAcademico::where('abreviatura', 'LMAD')->first();
        
        //Mientras los programas academicos que no sean LMAD no tienen informacion de sus planes acadaemicos
        if (!$lmad) {
            return;
        }

        $planes = ['420', '440'];

        foreach ($planes as $plan) {
            PlanAcademico::firstOrCreate(
                [
                    'nombre' => "Plan " . $plan,
                    'programa_academico_id' => $lmad->id,
                ],
                [
                    'estatus' => true,
                ],
            );
        }

    }
}
