<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\PlanAcademico;
use App\Models\ProgramaAcademico;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanAcademico>
 */
class PlanAcademicoFactory extends Factory
{
    protected $model = PlanAcademico::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => 'Plan ' . $this->faker->numberBetween(400, 499),
            'estatus' => true,
            'programa_academico_id' => ProgramaAcademico::factory(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'estatus' => false,
            ];
        });
    }
}
