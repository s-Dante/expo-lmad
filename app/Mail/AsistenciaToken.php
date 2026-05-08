<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Correo que se envía al registrarse en un evento (AFI).
 * Contiene el token que el visitante deberá ingresar en /Asistencia
 * al finalizar el evento para confirmar su asistencia completa.
 */
class AsistenciaToken extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nombreVisitante,
        public string $tituloEvento,
        public string $token
    ) {}

    public function build(): self
    {
        return $this
            ->subject('Tu token de asistencia - Expo LMAD')
            ->view('emails.asistencia-token');
    }
}
