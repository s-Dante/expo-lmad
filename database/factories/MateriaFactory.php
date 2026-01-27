<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Materia;
use App\Models\PlanAcademico;
use App\Models\Categoria;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Materia>
 */
class MateriaFactory extends Factory
{

    protected $model = Materia::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'clave' => $this->faker->optional()->bothify('MAT-###'),
            'nombre' => $this->faker->sentence(3),
            'abreviatura' => strtoupper($this->faker->optional()->lexify('???')),
            'descripcion' => $this->faker->optional()->paragraph(),
            'creditos' => $this->faker->numberBetween(1, 6),
            'semestre' => $this->faker->numberBetween(1, 10),
            'plan_academico_id' => PlanAcademico::factory(),
            'categoria_id' => Categoria::inRandomOrder()->first()?->id ?? Categoria::factory(),
        ];
    }
}
