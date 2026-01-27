<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Categoria;

class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    public function definition(): array
    {
        $nombre = fake()->unique()->words(2, true);
        return [
            'nombre' => ucfirst($nombre),
            'slug' => Str::slug($nombre),
        ];
    }
}