<?php

namespace App\Mail;

use App\Models\HealthCare;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class KesehatanNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $healthCare;

    /**
     * Create a new message instance.
     */
    public function __construct(HealthCare $healthCare)
    {
        $this->healthCare = $healthCare;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Informasi Pemeriksaan Kesehatan dari UKS',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.kesehatan',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
