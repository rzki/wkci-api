<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HandsOnRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $handsOn;
    public function __construct($handsOn)
    {
        $this->handsOn = $handsOn;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hands On Registration Successful',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.hands-on-registration',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
