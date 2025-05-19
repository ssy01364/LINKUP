<?php
namespace App\Mail;

use App\Models\Cita;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CitaActualizadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cita;
    public $nuevoEstado; // 'confirmada' o 'cancelada'

    public function __construct(Cita $cita, string $nuevoEstado)
    {
        $this->cita        = $cita;
        $this->nuevoEstado = $nuevoEstado;
    }

    public function build()
    {
        return $this->subject("Cita {$this->nuevoEstado}")
                    ->markdown('emails.citas.actualizada')
                    ->with([
                        'cita'        => $this->cita,
                        'nuevoEstado' => $this->nuevoEstado,
                    ]);
    }
}
