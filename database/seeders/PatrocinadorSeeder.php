<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Patrocinador;
use App\Models\Visitante;

class PatrocinadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patrocinador::factory(8)->create()->each(function ($patrocinador) {
            
            // LOGICA DE NEGOCIO:
            // Creamos entre 1 y 3 personas REALES (Visitantes) para esta empresa.
            // Forzamos el tipo 'sponsor' para que el sistema de QR sepa cómo tratarlos.
            $representantes = Visitante::factory(rand(1, 3))->create([
                'tipo' => 'sponsor',
                'matricula' => null, // No aplica
                'carrera' => null,   // No aplica
                'dependencia' => $patrocinador->nombre, // Usamos el nombre de la empresa como "Dependencia"
            ]);

            // Los vinculamos
            foreach ($representantes as $rep) {
                $patrocinador->representantes()->attach($rep->id, [
                    'cargo' => fake()->jobTitle(), // Ej: Recruiter, CTO
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
