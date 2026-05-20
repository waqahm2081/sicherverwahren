<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserWelcome extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function envelope(): Envelope
    {
        $subject = $this->user->preferred_language === 'en'
            ? 'Your registration at Sicher Bitcoin Verwahren'
            : 'Deine Registrierung bei Sicher Bitcoin Verwahren';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        $view = $this->user->preferred_language === 'en'
            ? 'emails.user-welcome-en'
            : 'emails.user-welcome-de';

        return new Content(view: $view);
    }
}