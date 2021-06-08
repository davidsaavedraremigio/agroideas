<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificarExpediente extends Mailable
{
    use Queueable, SerializesModels;

    public $expediente;
    public $entidad;
    public $responsable;

    public function __construct($expediente, $entidad, $responsable)
    {
        $this->expediente   =   $expediente;
        $this->entidad      =   $entidad;
        $this->responsable  =   $responsable;
    }

    public function build()
    {
        return $this->view("mail.template")
        ->from('aesip@agroideas.gob.pe')
        ->subject('Notificación de asignación del expediente Nº '.$this->expediente->nroExpediente.'.');
    }
}
