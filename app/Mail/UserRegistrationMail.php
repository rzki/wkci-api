<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $users;
    public function __construct($users)
    {
        $this->users = $users;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Registration Successful',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user-registration',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
