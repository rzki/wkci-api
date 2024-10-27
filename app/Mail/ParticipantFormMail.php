<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ParticipantFormMail extends Mailable
{
    use Queueable, SerializesModels;
    public $participant;
    public function __construct($participant)
    {
        $this->participant = $participant;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Participant Form Registration Successful',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.participant-form',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
