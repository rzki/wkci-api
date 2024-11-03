<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Milon\Barcode\DNS2D;

class PaymentPendingMail extends Mailable
{
    use Queueable, SerializesModels;
    public $result, $formData;
    public function __construct($result, $formData)
    {
        $this->result = $result;
        $this->formData = $formData;
        $this->qr = new DNS2D();
        $this->qrEmail = base64_decode($this->qr->getBarcodePNG($this->result['qrContent'], 'QRCODE'));
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Pending [#'.$this->result['referenceNo'].']',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-pending',
        );
    }

    public function attachments(): array
    {

        return [
            Attachment::fromData(fn()=> $this->qrEmail, uniqid().'_'.strtolower(str_replace(' ', '_', $this->formData['full_name']).'.png'))
                        ->withMime('image/png'),
        ];
    }
}
