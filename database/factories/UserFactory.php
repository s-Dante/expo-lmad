<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nombre = $this->faker->firstName();
        $apellido = $this->faker->lastName();
        
        return [
            'name' => strtolower($nombre . '.' . $apellido . rand(1, 99)), // username tipo dante.rodriguez12
            'nombre' => $nombre,
            'apellido_paterno' => $apellido,
            'apellido_materno' => $this->faker->optional()->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'llave_acceso' => $this->faker->optional()->uuid(),
            'rol' => 'estudiante',
            'estatus' => true,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Estatus por rol
     */
    public function superAdmin(): static
    {
        return $this->state(fn () => ['rol' => 'super_admin']);
    }

    public function admin(): static
    {
        return $this->state(fn () => ['rol' => 'admin']);
    }

    public function staff(): static
    {
        return $this->state(fn () => ['rol' => 'staff']);
    }

    public function profesor(): static
    {
        return $this->state(fn () => ['rol' => 'profesor']);
    }

    public function estudiante(): static
    {
        return $this->state(fn () => ['rol' => 'estudiante']);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
