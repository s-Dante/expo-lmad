<?php

namespace App\Services\Teacher;

use App\Models\Proyecto;
use App\Mail\ProyectoAsignadoLider;
use App\Mail\ProyectoAsignadoMiembro;
use Illuminate\Support\Facades\Mail;

class ProfesorEmailService
{
    /**
     * Recibe la lista de usuarios procesada por el repositorio y envía los correos.
     *
     * - Al líder: correo con el código de acceso para completar el proyecto.
     * - Al resto: correo informativo de que fueron asignados al equipo.
     *
     * Se carga la relación 'materia' del proyecto antes de enviar para que
     * las plantillas de correo puedan acceder a $proyecto->materia->nombre.
     */
    public function enviarCorreosAsignacion(Proyecto $proyecto, string $codigoAcceso, array $usuarios): array
    {
        // Asegurar que la relación materia esté cargada (evita N+1 y null en la vista)
        $proyecto->loadMissing('materia');

        $enviados  = [];
        $fallidos  = [];

        foreach ($usuarios as $dato) {
            $user    = $dato['user'];
            $esLider = $dato['es_lider'];

            // Saltar si el usuario no tiene correo registrado
            if (empty($user->email)) {
                $fallidos[] = $user->nombre . ' (sin correo)';
                continue;
            }

            try {
                if ($esLider) {
                    Mail::to($user->email)->send(
                        new ProyectoAsignadoLider($proyecto, $codigoAcceso, $user)
                    );
                } else {
                    Mail::to($user->email)->send(
                        new ProyectoAsignadoMiembro($proyecto, $user)
                    );
                }
                $enviados[] = $user->email;
            } catch (\Exception $e) {
                $fallidos[] = $user->email . ' (' . $e->getMessage() . ')';
            }
        }

        return ['enviados' => $enviados, 'fallidos' => $fallidos];
    }
}