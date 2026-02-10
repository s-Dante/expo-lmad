<?php

namespace App\Services\Student;

use App\Models\Proyecto;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class EstudianteService
{
    /**
     * Maneja la actualización completa: datos + archivo + cambio de estatus
     */
    public function procesarActualizacionProyecto(Proyecto $proyecto, array $datos, ?UploadedFile $poster = null)
    {
        // 1. Generar Slug único
        $slug = Str::slug($datos['titulo']);
        // Pequeña validación para evitar duplicados exactos (opcional, pero recomendada)
        if (Proyecto::where('slug', $slug)->where('id', '!=', $proyecto->id)->exists()) {
            $slug .= '-' . Str::random(5);
        }

        // 2. Determinar Estatus
        // Si el usuario marcó "enviar_revision", cambiamos a 'enviado', si no, se queda en 'borrador'
        $nuevoEstatus = isset($datos['enviar_revision']) ? 'enviado' : 'borrador';

        // 3. Actualizar Datos Base
        $proyecto->update([
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'],
            'slug' => $slug,
            'estatus' => $nuevoEstatus,
            'retroalimentacion' => ($nuevoEstatus === 'enviado') ? null : $proyecto->retroalimentacion,
        ]);

        // 4. Sincronizar Softwares (Tabla Pivote)
        if (isset($datos['softwares']) && is_array($datos['softwares'])) {
            $proyecto->softwares()->sync($datos['softwares']);
        }

        // 5. Manejo de Multimedia

        // A) PORTADA (Imagen)
        if ($poster) {
            $path = $poster->store('proyectos/posters', 'public');
            $proyecto->multimedia()->updateOrCreate(
                ['es_portada' => true],
                ['tipo' => 'imagen', 'url' => $path, 'titulo' => 'Portada Oficial']
            );
        }

        // B) YOUTUBE (Video Principal)
        if (!empty($datos['link_youtube'])) {
            $embedUrl = $this->sanitizarYoutube($datos['link_youtube']);
            if ($embedUrl) {
                $proyecto->multimedia()->updateOrCreate(
                    ['tipo' => 'youtube'], // Buscamos por tipo para solo tener un video principal
                    [
                        'url' => $embedUrl, 
                        'titulo' => 'Video Demo', 
                        'es_portada' => false
                    ]
                );
            }
        }

        // C) ENLACES EXTERNOS (Drive / Github)
        // Borramos los anteriores de este tipo para evitar duplicados infinitos al editar
        $proyecto->multimedia()->whereIn('tipo', ['drive', 'github'])->delete();

        if (!empty($datos['link_drive'])) {
            $proyecto->multimedia()->create([
                'tipo' => 'drive',
                'url' => $datos['link_drive'],
                'titulo' => 'Google Drive'
            ]);
        }

        if (!empty($datos['link_github'])) {
            $proyecto->multimedia()->create([
                'tipo' => 'github',
                'url' => $datos['link_github'],
                'titulo' => 'Repositorio GitHub'
            ]);
        }

        return $proyecto;
    }

    /**
     * Convierte cualquier link de YT en formato embed
     * @return string|null Retorna la URL https://www.youtube.com/embed/ID o null si falla
     */
    private function sanitizarYoutube(string $url): ?string
    {
        // Patrón Regex para capturar el ID de video (funciona con share, url, embed, short)
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        
        if (preg_match($pattern, $url, $matches)) {
            $videoId = $matches[1];
            return "https://www.youtube.com/embed/" . $videoId;
        }

        return null; // O retornar la url original si prefieres no ser estricto
    }
}