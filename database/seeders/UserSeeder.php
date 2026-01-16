<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;

use App\Models\User;
use App\Models\Estudiante;
use App\Models\Profesor;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ==========================================
        // 1. USUARIOS ADMINISTRATIVOS (Siempre se crean)
        // ==========================================
        
        // 3 Super Admins
        $this->createFixedUser('super_admin', 'Coordinacion', 'superadmin1@lmad.com');
        $this->createFixedUser('super_admin', 'Expo', 'superadmin2@lmad.com');
        $this->createFixedUser('super_admin', 'Multimedia', 'superadmin3@lmad.com');

        // 2 Admins
        $this->createFixedUser('admin', 'admin1', 'admin1@lmad.com');
        $this->createFixedUser('admin', 'admin2', 'admin2@lmad.com');

        // 1 Staff
        $this->createFixedUser('staff', 'staff1', 'staff1@lmad.com');

        // ==========================================
        // 2. VINCULACIÓN CON PADRÓN (Solo en Local/Desarrollo)
        // ==========================================
        if (App::environment('local')) {
            $this->createUsersForPadron();
        }
    }

    /**
     * Helper para crear usuarios fijos si no existen.
     */
    private function createFixedUser(string $rol, string $username, string $email): void
    {
        User::firstOrCreate(
            ['email' => $email], // Buscamos por email para no duplicar
            [
                'name' => $username,
                'nombre' => ucfirst($rol),
                'apellido_paterno' => 'LMAD',
                'password' => Hash::make('password'), // Contraseña genérica segura para dev
                'rol' => $rol,
                'estatus' => true,
            ]
        );
    }

    /**
     * Lógica para asignar cuentas a estudiantes y profesores existentes.
     */
    private function createUsersForPadron(): void
    {
        // A. Dar cuenta a 20 Estudiantes al azar que aún no tengan usuario
        $estudiantesSinCuenta = Estudiante::whereNull('usuario_id')->inRandomOrder()->take(20)->get();
        
        foreach ($estudiantesSinCuenta as $estudiante) {
            $user = User::factory()->create([
                'nombre' => $estudiante->nombre,
                'apellido_paterno' => $estudiante->apellido_paterno,
                'apellido_materno' => $estudiante->apellido_materno,
                'email' => $estudiante->email ?? fake()->unique()->safeEmail(), // Usamos su email o generamos uno
                'rol' => 'estudiante',
            ]);

            // Actualizamos el registro del padrón con el ID del nuevo usuario
            $estudiante->update(['usuario_id' => $user->id]);
        }

        // B. Dar cuenta a 5 Profesores al azar
        $profesoresSinCuenta = Profesor::whereNull('usuario_id')->inRandomOrder()->take(5)->get();
        
        foreach ($profesoresSinCuenta as $profesor) {
            $user = User::factory()->create([
                'nombre' => $profesor->nombre,
                'apellido_paterno' => $profesor->apellido_paterno,
                'apellido_materno' => $profesor->apellido_materno,
                'email' => $profesor->email ?? fake()->unique()->safeEmail(),
                'rol' => 'profesor',
            ]);

            $profesor->update(['usuario_id' => $user->id]);
        }
    }
}
