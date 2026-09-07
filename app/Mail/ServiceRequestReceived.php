<?php

namespace App\Mail;

use App\Models\ServiceRequest;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;

class ServiceRequestReceived extends Mailable
{
    public function __construct(public ServiceRequest $serviceRequest)
    {
        $this->serviceRequest->loadMissing(['category.translations', 'service.translations']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Neue Serviceanfrage – '.$this->serviceRequest->name,
            replyTo: [$this->serviceRequest->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.service-request-received',
        );
    }

    public function headers(): Headers
    {
        return new Headers(
            text: [
                'Auto-Submitted' => 'auto-generated',
            ],
        );
    }
}
