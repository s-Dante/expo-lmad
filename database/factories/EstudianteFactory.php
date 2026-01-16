<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Estudiante;
use App\Models\ProgramaAcademico;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estudiante>
 */
class EstudianteFactory extends Factory
{
    protected $model = Estudiante::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matricula' => $this->faker->unique()->numerify('#######'),
            'nombre' => $this->faker->firstName(),
            'apellido_paterno' => $this->faker->lastName(),
            'apellido_materno' => $this->faker->lastName(),
            'semestre' => $this->faker->numberBetween(1, 10),
            'usuario_id' => null,
            'email' => $this->faker->unique()->safeEmail(),
            'programa_academico_id' => ProgramaAcademico::factory(),
        ];
    }

    public function forPrograma(ProgramaAcademico $programa): static
    {
        return $this->state(fn () => [
            'programa_academico_id' => $programa->id,
        ]);
    }

}
