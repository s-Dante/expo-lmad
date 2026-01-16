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
        $titulo = $this->faker->sentence(4);

        return [
            'titulo' => $titulo,
            'descripcion' => $this->faker->paragraph(),
            'slug' => Str::slug($titulo) . '-' . Str::random(5),
            'estatus' => 'borrador',
            'codigo_acceso' => strtoupper(Str::random(8)),
            'profesor_id' => Profesor::factory(),
            'materia_id' => Materia::factory(),
            'periodo_semestral' => '2025-1',
        ];
    }

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
