<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserApproved extends Mailable
{
    use Queueable, SerializesModels;

    public string $expiryDate;

    public function __construct(public User $user)
    {
        $this->expiryDate = optional($user->access_ends_at)->format('d.m.Y')
            ?? now()->addDays(60)->format('d.m.Y');
    }

    public function envelope(): Envelope
    {
        $subject = $this->user->preferred_language === 'en'
            ? 'Your account has been approved'
            : 'Ihr Zugang wurde freigeschaltet – ' . ($this->user->selected_package ?? 'Paket');

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        $view = $this->user->preferred_language === 'en'
            ? 'emails.user-approved-en'
            : 'emails.user-approved-de';

        return new Content(view: $view);
    }
}
