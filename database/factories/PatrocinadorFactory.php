<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Patrocinador;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patrocinador>
 */
class PatrocinadorFactory extends Factory
{
    protected $model = Patrocinador::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->company(),
            'tier' => fake()->randomElement(['Bronce', 'Plata', 'Oro', 'Platino']),
            'logo_url' => fake()->imageUrl(200, 200, 'business'),
            'website_url' => fake()->url(),
        ];
    }
}
