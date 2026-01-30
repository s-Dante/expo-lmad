<?php

namespace App\Services\Student;

use App\Models\Proyecto;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EstudianteService
{
    /**
     * Maneja la actualización completa: datos + archivo + cambio de estatus
     */
    public function procesarActualizacionProyecto(Proyecto $proyecto, array $datos, ?UploadedFile $poster = null)
    {
        // 1. Manejo del Archivo (Poster)
        if ($poster) {
            // Guardar en disco 'public' dentro de carpeta 'posters'
            $ruta = $poster->store('proyectos/posters', 'public');

            // Actualizar o Crear registro en tbl_multimedia_proyectos
            $proyecto->multimedia()->updateOrCreate(
                ['es_portada' => true], // Condición de búsqueda
                [
                    'tipo' => 'imagen',
                    'url' => $ruta,
                    'titulo' => 'Poster del Proyecto'
                ] // Valores a guardar
            );
        }

        // 2. Regla de Negocio: Cambiar estatus
        // Si estaba en borrador o rechazado, pasa a 'enviado' para revisión
        if (in_array($proyecto->estatus, ['borrador', 'rechazado'])) {
            $proyecto->estatus = 'enviado';
            $proyecto->retroalimentacion = null; // Limpiar feedback viejo
        }

        // 3. Persistir cambios en el modelo principal
        $proyecto->titulo = $datos['titulo'];
        $proyecto->descripcion = $datos['descripcion'];
        $proyecto->save();

        return $proyecto;
    }
}