<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\ProgramaAcademico;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProgramaAcademico>
 */
class ProgramaAcademicoFactory extends Factory
{
    protected $model = ProgramaAcademico::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->words(3, true),
            'abreviatura' => strtoupper($this->faker->unique()->lexify('???')),
            'descripcion' => $this->faker->sentence(),
            'estatus' => true,
        ];
    }

    /**
     * Estado inactivo del programa académico.
     */
    public function inactive(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'estatus' => false,
            ];
        });
    }
}
