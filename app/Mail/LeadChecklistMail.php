<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadChecklistMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $leadName) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ihre kostenlose Bitcoin-Sicherheits-Checkliste',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.lead-checklist',
        );
    }

    public function attachments(): array
    {
        $path = public_path('images/Bitcoin_Sicherheits_Selbsttest_2026.pdf');

        return [
            Attachment::fromPath($path)
                ->as('Bitcoin_Sicherheits_Selbsttest_2026.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
