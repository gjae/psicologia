<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use App\Models\user;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $apiResponse;
    public $fecha;
    public $hora;

    public function __construct($apiResponse, $fecha, $hora)
    {
        //

        $this->apiResponse = $apiResponse;
        $this->fecha= $fecha;
        $this->hora= $hora;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('psicologomonterrico@gmail.com', 'Psicólogo Monterrico'),
            subject: 'Se ha agendado su cita de atención psicológica',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mails.appointment_notification',
            with: [
                'apiResponse' => $this->apiResponse,
                'fecha'=> $this->fecha,
                'hora'=> $this->hora
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
