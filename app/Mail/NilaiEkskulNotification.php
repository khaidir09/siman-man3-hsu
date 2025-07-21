<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Extracurricular;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class NilaiEkskulNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $extracurricular;
    public $grade;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Extracurricular $extracurricular, string $grade)
    {
        $this->user = $user;
        $this->extracurricular = $extracurricular;
        $this->grade = $grade;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pembaruan Nilai Ekstrakurikuler',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.nilai-ekskul',
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
