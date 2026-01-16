<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Evento;
use App\Models\Conferencista;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenemos los IDs de los conferencistas creados previamente
        $conferencistasIds = Conferencista::all()->pluck('id');

        if ($conferencistasIds->isEmpty()) {
            // Fallback por si corres este seeder solo sin conferencistas previos
            $conferencistasIds = Conferencista::factory(5)->create()->pluck('id');
        }

        // Creamos 10 eventos
        Evento::factory(10)->create()->each(function ($evento) use ($conferencistasIds) {
            // A cada evento le asignamos entre 1 y 2 conferencistas aleatorios
            $evento->conferencistas()->attach(
                $conferencistasIds->random(rand(1, 2))
            );
        });
    }
}
