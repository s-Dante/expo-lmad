<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Visitante;
use App\Models\Evento;

class VisitanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear visitantes
        $visitantes = Visitante::factory(50)->create();

        // 2. Obtener eventos disponibles
        $eventos = Evento::all();

        if ($eventos->isEmpty()) {
            return; // Si no hay eventos, no podemos registrar asistencias
        }

        // 3. Simular registros y asistencias
        $visitantes->each(function ($visitante) use ($eventos) {
            // Cada visitante se registra a 1-3 eventos aleatorios
            $eventosAleatorios = $eventos->random(rand(1, 3));

            foreach ($eventosAleatorios as $evento) {
                // Simulamos lógica de negocio: 
                // 80% de probabilidad de que sí haya asistido
                $asistio = fake()->boolean(80);
                
                // La fecha de asistencia debe ser cercana a la fecha del evento
                $fechaEvento = $evento->fecha_inicio_evento;
                $fechaAsistencia = (clone $fechaEvento)->modify('+' . rand(0, 30) . ' minutes');

                $visitante->eventos()->attach($evento->id, [
                    'asistencia' => $asistio,
                    'fecha_asistencia' => $fechaAsistencia,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
