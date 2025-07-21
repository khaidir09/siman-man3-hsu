<?php

namespace App\Mail;

use App\Models\LateArrival;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class PelanggaranKedisiplinanNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $lateArrival;

    /**
     * Create a new message instance.
     */
    public function __construct(LateArrival $lateArrival)
    {
        $this->lateArrival = $lateArrival;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notifikasi Pelanggaran Kedisiplinan',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pelanggaran-kedisiplinan',
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
