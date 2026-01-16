<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Profesor;
use App\Models\Materia;
use App\Models\Proyecto;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proyecto>
 */
class ProyectoFactory extends Factory
{
    protected $model = Proyecto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titulo = fake()->unique()->sentence(rand(3, 6));
        
        return [
            'titulo' => $titulo,
            'descripcion' => fake()->paragraphs(3, true),
            'slug' => Str::slug($titulo) . '-' . rand(100, 999),
            'estatus' => fake()->randomElement(['borrador', 'enviado', 'aprobado', 'rechazado']),
            'codigo_acceso' => strtoupper(Str::random(8)), // Genera algo como A8X12B9Z
            'periodo_semestral' => 'Agosto - Diciembre 2025',
            'profesor_id' => Profesor::factory(),
            'materia_id' => Materia::factory(),
        ];
    }

    /**
     * Estado de recien creado por el profesor
     */
    public function borrador(): static
    {
        return $this->state(fn (array $attributes) => [
            'estatus' => 'borrador',
            'titulo' => 'Proyecto Asignado #' . rand(1000, 9999), // Placeholder
            'descripcion' => null,
            'slug' => 'temp-' . Str::random(10),
        ]);
    }

    //Otros estados (checar)
    public function enviado(): static
    {
        return $this->state(fn () => [
            'estatus' => 'enviado',
        ]);
    }

    public function aprobado(): static
    {
        return $this->state(fn () => [
            'estatus' => 'aprobado',
        ]);
    }
}
