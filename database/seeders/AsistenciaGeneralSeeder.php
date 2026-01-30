<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estudiante;
use App\Models\AsistenciaGeneral;

class AsistenciaGeneralSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Obtener todos los estudiantes existentes
        $estudiantes = Estudiante::all();

        if ($estudiantes->isEmpty()) {
            $this->command->info('No hay estudiantes en la base de datos. Seeder de asistencia omitido.');
            return;
        }

        // 2. Definir cuántos asistirán (Ej: 70% de asistencia aleatoria)
        // shuffle() mezcla el orden para que sea aleatorio
        $asistentes = $estudiantes->shuffle()->take((int) ($estudiantes->count() * 0.7));

        // 3. Crear el registro de asistencia para los seleccionados
        foreach ($asistentes as $estudiante) {
            // Usamos firstOrCreate para evitar duplicados si corres el seeder dos veces
            AsistenciaGeneral::firstOrCreate(
                ['estudiante_id' => $estudiante->id],
                ['hora_entrada' => now()->subHours(rand(1, 4))] // Hora aleatoria
            );
        }

        $this->command->info('Asistencias generadas: ' . $asistentes->count() . ' de ' . $estudiantes->count() . ' estudiantes.');
    }
}