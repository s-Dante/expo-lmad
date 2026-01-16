<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Conferencista;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conferencista>
 */
class ConferencistaFactory extends Factory
{
    protected $model = Conferencista::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->firstName(),
            'apellido_paterno' => fake()->lastName(),
            'apellido_materno' => fake()->lastName(),
            'nickname' => fake()->unique()->userName(), // Útil para URLs de perfil
            'biografia' => fake()->paragraph(),
            'email' => fake()->unique()->safeEmail(),
            'telefono' => fake()->phoneNumber(),
            'empresa' => fake()->company(),
            'cargo' => fake()->jobTitle(),
            'foto_url' => fake()->imageUrl(640, 480, 'people'),
            'estatus' => true,
        ];
    }
}
