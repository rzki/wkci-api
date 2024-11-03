<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessfulMail extends Mailable
{
    use Queueable, SerializesModels;
    public $handsOn, $result, $refNo;
    public function __construct($form, $resultCache, $refNo)
    {
        $this->handsOn = $form;
        $this->result = $resultCache;
        $this->refNo = $refNo;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Successful [#'.$this->result['referenceNo'] ?? $this->refNo.']',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-successful',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
