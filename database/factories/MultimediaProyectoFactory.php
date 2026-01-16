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
    protected $model = MultimediaProyecto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipo = $this->faker->randomElement(['imagen', 'video', 'documento', 'youtube', 'drive', 'github']);
        
        $url = match ($tipo) {
            'imagen' => $this->faker->imageUrl(800, 600, 'technics', true, 'Proyecto'),
            'youtube' => 'https://www.youtube.com/watch?v=' . $this->faker->regexify('[a-zA-Z0-9_-]{11}'),
            'github' => 'https://github.com/' . $this->faker->userName() . '/' . $this->faker->slug(),
            'drive' => 'https://drive.google.com/file/d/' . $this->faker->regexify('[a-zA-Z0-9_-]{20}'),
            default => $this->faker->url(),
        };

        return [
            'proyecto_id' => Proyecto::factory(),
            'tipo' => $tipo,
            'url' => $url,
            'titulo' => $this->faker->sentence(3),
            'descripcion' => $this->faker->optional()->sentence(),
            'es_portada' => false,
        ];
    }


    public function portada(): static
    {
        return $this->state(fn () => [
            'es_portada' => true,
            'tipo' => 'imagen',
            'url' => $this->faker->imageUrl(1280, 720, 'business', true, 'Portada'),
        ]);
    }

}
