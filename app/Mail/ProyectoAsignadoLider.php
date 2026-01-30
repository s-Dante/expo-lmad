<?php

namespace App\Mail;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProyectoAsignadoLider extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Proyecto $proyecto,
        public string $codigoAcceso,
        public User $usuario
    ) {}

    public function build()
    {
        return $this->subject('Eres Líder de Proyecto - Expo LMAD')
                    ->view('emails.proyecto-lider');
    }
}