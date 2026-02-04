<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estudiante;
use App\Models\AsistenciaGeneral;

class AsistenciaGeneralSeeder extends Seeder
{
    public function run(): void
    {
        // 1. OBTENER SOLO ESTUDIANTES CON CUENTA DE USUARIO
        // Filtramos donde 'usuario_id' no sea nulo
        $estudiantes = Estudiante::whereNotNull('usuario_id')->get();

        if ($estudiantes->isEmpty()) {
            $this->command->warn('No se encontraron estudiantes con usuario vinculado. Seeder de asistencia omitido.');
            return;
        }

        // 2. Definir cuántos asistirán (Ej: 70% de los que tienen cuenta)
        // shuffle() mezcla el orden para que sea aleatorio
        $asistentes = $estudiantes->shuffle()->take((int) ($estudiantes->count() * 0.7));

        // 3. Crear el registro de asistencia
        foreach ($asistentes as $estudiante) {
            AsistenciaGeneral::firstOrCreate(
                ['estudiante_id' => $estudiante->id],
                [
                    // Generamos una hora aleatoria entre hace 1 y 4 horas
                    'hora_entrada' => now()->subHours(rand(1, 4)) 
                ]
            );
        }

        $this->command->info('✅ Asistencias generadas: ' . $asistentes->count() . ' de ' . $estudiantes->count() . ' estudiantes con cuenta activa.');
    }
}