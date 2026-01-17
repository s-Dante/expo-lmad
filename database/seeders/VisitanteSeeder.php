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
        $visitantes = Visitante::factory(50)->create();

        $eventos = Evento::all();

        if ($eventos->isEmpty()) {
            return;
        }

        $visitantes->each(function ($visitante) use ($eventos) {
            
            $eventosAsistidos = $eventos->random(rand(1, 3));

            foreach ($eventosAsistidos as $evento) {
                $asistio = fake()->boolean(80);

                $inicioEvento = $evento->fecha_inicio_evento;

                $checkIn = (clone $inicioEvento)->modify(rand(-10, 15) . ' minutes');
                
                $checkOut = $asistio ? (clone $checkIn)->modify('+' . rand(30, 60) . ' minutes') : null;

                $visitante->eventos()->attach($evento->id, [
                    'asistencia' => $asistio,
                    'fecha_registro' => $checkIn,
                    'fecha_salida' => $checkOut,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
