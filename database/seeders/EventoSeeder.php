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
        $conferencistas = Conferencista::all();

        if ($conferencistas->isEmpty()) {
            $conferencistas = Conferencista::factory(10)->create();
        }

        Evento::factory(15)->create()->each(function ($evento) use ($conferencistas) {
            $cantidadSpeakers = fake()->boolean(80) ? 1 : rand(2, 3);

            $speakersSeleccionados = $conferencistas->random(min($cantidadSpeakers, $conferencistas->count()));

            $evento->conferencistas()->attach($speakersSeleccionados);
        });
    }
}
