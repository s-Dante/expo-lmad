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
     */
    public function enviarCorreosAsignacion(Proyecto $proyecto, string $codigoAcceso, array $usuarios)
    {
        foreach ($usuarios as $dato) {
            $user = $dato['user'];
            $esLider = $dato['es_lider'];

            if ($esLider) {
                Mail::to($user->email)->send(new ProyectoAsignadoLider($proyecto, $codigoAcceso, $user));
            } else {
                Mail::to($user->email)->send(new ProyectoAsignadoMiembro($proyecto, $user));
            }
        }
    }
}