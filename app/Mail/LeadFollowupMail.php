<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadFollowupMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $leadName) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Wie sicher ist Ihr Bitcoin-Setup wirklich?');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.lead-followup');
    }
}
