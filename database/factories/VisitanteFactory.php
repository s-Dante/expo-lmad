<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Visitante;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitante>
 */
class VisitanteFactory extends Factory
{
    protected $model = Visitante::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipo = fake()->randomElement(['externo', 'estudiante', 'sponsor', 'staff', 'profesor', 'directivos']);
        
        // Datos base
        $data = [
            'tipo' => $tipo,
            'uuid' => fake()->uuid(), // HasUuids lo sobreescribe, pero útil para tests unitarios raw
            'genero' => fake()->randomElement(['M', 'F', 'O']),
            'rango-edad' => fake()->randomElement(['<15', '15-25', '26-35', '36-45', '46-55', '56+']),
        ];

        // Lógica condicional para datos UANL
        if ($tipo === 'estudiante') {
            $data['matricula'] = (string) fake()->numberBetween(1400000, 2100000);
            $data['dependencia'] = 'FCFM';
            $data['carrera'] = fake()->randomElement(['LMAD', 'LCC', 'LSTI', 'LA', 'LF']);
            $data['semestre'] = (string) fake()->numberBetween(1, 9);
        } else {
            $data['matricula'] = null;
            $data['dependencia'] = fake()->optional()->company(); // A veces traen dependencia externa
            $data['carrera'] = null;
            $data['semestre'] = null;
        }

        return $data;
    }
}
