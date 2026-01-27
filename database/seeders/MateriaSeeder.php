<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materia;
use App\Models\PlanAcademico;
use App\Models\Categoria;

class MateriaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Obtenemos el plan académico
        $plan = PlanAcademico::where('nombre', 'Plan 420')->first(); 

        if (!$plan) {
            $this->command->error('No se encontró el Plan 420. Ejecuta el PlanAcademicoSeeder primero.');
            return;
        }

        // 2. RECUPERAMOS LAS CATEGORÍAS (Asumiendo que ya corriste CategoriaSeeder)
        // Usamos first() para obtener el objeto y sacar su ID más abajo.
        $catProgra = Categoria::where('slug', 'programacion')->first();
        $catArte = Categoria::where('slug', 'arte')->first();
        $catRV = Categoria::where('slug', 'realidad-virtual')->first();
        $catJuegos = Categoria::where('slug', 'videojuegos')->first();
        
        // Fallback de seguridad: Si por alguna razón no existen, usamos una por defecto o creamos al vuelo
        // (Aunque si corriste CategoriaSeeder, esto no debería pasar)
        $catDefault = $catProgra ?? Categoria::factory()->create(['nombre' => 'General', 'slug' => 'general']);


        // 3. DEFINIMOS LAS MATERIAS CON SU CATEGORÍA ESPECÍFICA
        $materias = [ 
            [
                'clave' => 'MAT101',
                'nombre' => 'Matemáticas I',
                'abreviatura' => 'MAT I',
                'creditos' => 8,
                'semestre' => 1,
                'categoria_id' => $catProgra->id, // <--- AQUÍ asignas manualmente (Matemáticas -> Progra por lógica computacional)
            ],
            [
                'clave' => 'PRO102',
                'nombre' => 'Programación I',
                'abreviatura' => 'PRO I',
                'creditos' => 8,
                'semestre' => 1,
                'categoria_id' => $catProgra->id, // <--- Asignado a Programación
            ],
            [
                'clave' => 'ART101',
                'nombre' => 'Fundamentos de Arte',
                'abreviatura' => 'ART I',
                'creditos' => 5,
                'semestre' => 1,
                'categoria_id' => $catArte->id ?? $catDefault->id, // <--- Asignado a Arte
            ],
            [
                'clave' => 'RV101',
                'nombre' => 'Fundamentos de RV',
                'abreviatura' => 'RV I',
                'creditos' => 5,
                'semestre' => 1,
                'categoria_id' => $catRV->id ?? $catDefault->id, // <--- Asignado a RV
            ],
            [
                'clave' => 'VJ101',
                'nombre' => 'Fundamentos de Videojuegos',
                'abreviatura' => 'VJ I',
                'creditos' => 5,
                'semestre' => 1,
                'categoria_id' => $catJuegos->id ?? $catDefault->id, // <--- Asignado a Videojuegos
            ],
        ];

        // 4. EL LOOP DE CREACIÓN
        foreach ($materias as $datos) {
            Materia::firstOrCreate(
                [
                    // Criterios de búsqueda (para no duplicar)
                    'clave' => $datos['clave'],
                    'plan_academico_id' => $plan->id,
                ],
                [
                    // Datos a insertar si no existe
                    'nombre' => $datos['nombre'],
                    'abreviatura' => $datos['abreviatura'],
                    'creditos' => $datos['creditos'],
                    'semestre' => $datos['semestre'],
                    'categoria_id' => $datos['categoria_id'], // <--- IMPORTANTE: Pasamos el ID aquí
                ]
            );
        }
    }
}