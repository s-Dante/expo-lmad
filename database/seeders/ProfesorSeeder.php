<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Profesor;
use App\Models\ProgramaAcademico;
use App\Models\Materia;

class ProfesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (ProgramaAcademico::count() === 0) {
            return;
        }

        // Profesores Aleatorios
        Profesor::factory(10)->create()->each(function ($profesor) {

            $programas = ProgramaAcademico::inRandomOrder()->limit(rand(1, 2))->get();
            $profesor->programasAcademicos()->attach($programas->pluck('id'));

            $materiasValidas = Materia::whereHas('planAcademico', function (Builder $query) use ($programas) {
                $query->whereIn('programa_academico_id', $programas->pluck('id'));
            })->get();

            if ($materiasValidas->isNotEmpty()) {
                $profesor->materias()->attach(
                    $materiasValidas->random(min(3, $materiasValidas->count()))
                );
            }
        });

        // Profesor específico de LMAD
        $profeLmad = Profesor::firstOrCreate(
            ['numero_empleado' => '99999'], // Buscamos por este campo único
            [
                'nombre' => 'Profesor',
                'apellido_paterno' => 'De Prueba',
                'apellido_materno' => 'LMAD',
                'email' => 'profe.lmad@uanl.edu.mx',
                'usuario_id' => null
            ]
        );

        
        $programaLmad = ProgramaAcademico::where('abreviatura', 'LMAD')->first();
        
        if ($programaLmad) {
            $profeLmad->programasAcademicos()->syncWithoutDetaching([$programaLmad->id]);

            $materiasLmad = Materia::whereHas('planAcademico', function ($q) use ($programaLmad) {
                $q->where('programa_academico_id', $programaLmad->id);
            })->limit(3)->get();

            if ($materiasLmad->isNotEmpty()) {
                $profeLmad->materias()->syncWithoutDetaching($materiasLmad->pluck('id'));
            }
        }
    }
}
