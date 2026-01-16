<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Evento;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
{
    protected $model = Evento::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titulo = fake()->sentence(4);
        $fechaInicio = fake()->dateTimeBetween('now', '+1 month');
        // Clonamos la fecha para añadirle horas y evitar modificar la original por referencia si fuera objeto mutable (aunque fake devuelve nuevos, es seguridad)
        $fechaFin = (clone $fechaInicio)->modify('+'.rand(1, 4).' hours');

        return [
            'titulo' => $titulo,
            'slug' => Str::slug($titulo) . '-' . fake()->unique()->numerify('####'),
            'tipo' => fake()->randomElement(['conferencia', 'taller', 'seminario', 'webinar']),
            'descripcion_evento' => fake()->paragraphs(2, true),
            'fecha_inicio_evento' => $fechaInicio,
            'fecha_fin_evento' => $fechaFin,
            'ubicacion_evento' => fake()->randomElement(['Auditorio A', 'Sala B', 'Laboratorio 1', 'Online']),
            'capacidad' => fake()->numberBetween(20, 200),
            'poster_evento' => fake()->imageUrl(800, 600, 'tech_event'),
            'estatus_evento' => 'programado',
        ];
    }
}
