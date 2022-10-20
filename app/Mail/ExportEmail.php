<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExportEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(protected string $filename)
    {
        //
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'As combinações de cerveja que você pediu!',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.export',
            with: [
                'filename' => $this->filename
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [
            Attachment::fromStorage($this->filename)
        ];
    }
}
