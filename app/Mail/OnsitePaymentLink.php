<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OnsitePaymentLink extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function envelope(): Envelope
    {
        $isEnterprise = stripos((string) $this->user->selected_package, 'Enterprise') !== false;

        if ($this->user->preferred_language === 'en') {
            $subject = 'Your appointment is confirmed – complete your payment';
        } elseif ($isEnterprise) {
            $subject = 'Ihr persönlicher Zahlungslink – Business Enterprise';
        } else {
            $subject = 'Ihr persönlicher Zahlungslink – ' . ($this->user->selected_package ?? 'Vor-Ort-Service');
        }

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        $view = $this->user->preferred_language === 'en'
            ? 'emails.onsite-payment-link-en'
            : 'emails.onsite-payment-link-de';

        return new Content(view: $view);
    }
}
