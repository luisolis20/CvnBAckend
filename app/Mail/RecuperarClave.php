<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecuperarClave extends Mailable
{
    use Queueable, SerializesModels;
    public $claverecuperada; 
    /**
     * Create a new message instance.
     */
    public function __construct($claverecuperada)
    {
        $this->claverecuperada = $claverecuperada;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recuperación de Clave',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.recuperar-clave',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function build()
    {
        return $this->subject('Asunto del Correo')
                    ->view('mails.recuperar-clave')
                    ->with(['claverecuperada' => $this->claverecuperada]);
    }

}
