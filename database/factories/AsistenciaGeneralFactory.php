<?php

namespace Database\Factories;

use App\Models\AsistenciaGeneral;
use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Factories\Factory;

class AsistenciaGeneralFactory extends Factory
{
    protected $model = AsistenciaGeneral::class;

    public function definition(): array
    {
        return [
            // Por defecto crea un estudiante nuevo si no se le pasa uno
            'estudiante_id' => Estudiante::factory(),
            // Simula una hora de entrada entre las 8am y 12pm del día actual
            'hora_entrada' => $this->faker->dateTimeBetween('now 08:00', 'now 12:00'),
        ];
    }
}