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
    public $link;
    public $fecha;
    public $hora;
    public $appointment_date;

    public function __construct($link, $fecha, $appointment_date, $hora)
    {
        //

        $this->link = $link;
        $this->fecha= $fecha;
        $this->appointment_date= $appointment_date;
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
                'link' => $this->link,
                'fecha'=> $this->fecha,
                'appointment_date'=> $this->appointment_date,
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
