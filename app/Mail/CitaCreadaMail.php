<?php
namespace App\Mail;

use App\Models\Cita;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CitaCreadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cita;
    public $actor; // 'cliente' o 'empresa'

    public function __construct(Cita $cita, string $actor)
    {
        $this->cita  = $cita;
        $this->actor = $actor;
    }

    public function build()
    {
        return $this->subject('Nueva cita reservada')
                    ->markdown('emails.citas.creada')
                    ->with([
                        'cita'  => $this->cita,
                        'actor' => $this->actor,
                    ]);
    }
}
