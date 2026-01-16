<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Proyecto;
use App\Models\MultimediaProyecto;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MultimediaProyecto>
 */
class MultimediaProyectoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'proyecto_id' => Proyecto::factory(),
            'tipo' => $this->faker->randomElement([
                'imagen',
                'video',
                'documento',
                'youtube',
                'drive',
                'github',
            ]),
            'url' => $this->faker->url(),
            'titulo' => $this->faker->optional()->sentence(3),
            'descripcion' => $this->faker->optional()->paragraph(),
            'es_portada' => false,
        ];
    }

    public function portada(): static
    {
        return $this->state(fn () => [
            'es_portada' => true,
        ]);
    }

}
