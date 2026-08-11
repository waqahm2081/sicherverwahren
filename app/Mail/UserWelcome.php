<?php

namespace App\Mail;

use App\Models\PricingPackageOption;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserWelcome extends Mailable
{
    use Queueable, SerializesModels;

    public ?string $amountFormatted = null;

    public function __construct(public User $user)
    {
        if ($user->selected_option_type === 'digital' && $user->selected_package) {
            $option = PricingPackageOption::whereHas('package', function ($q) use ($user) {
                $q->where('name', $user->selected_package);
            })
                ->where('type', 'digital')
                ->first();

            if ($option) {
                $this->amountFormatted = number_format((float) $option->price_chf, 0, '.', "'");
            }
        }
    }

    public function envelope(): Envelope
    {
        if ($this->user->preferred_language === 'en') {
            $subject = 'Your registration at Sicher Bitcoin Verwahren';
        } elseif ($this->user->selected_option_type === 'onsite') {
            $package = $this->user->selected_package ?? 'Business Enterprise';
            $subject = str_contains($package, 'Enterprise')
                ? 'Ihre Anfrage für Business Enterprise ist eingegangen'
                : 'Ihre Anfrage für ' . $package . ' ist eingegangen';
        } else {
            $subject = 'Bestellung bestätigt – ' . ($this->user->selected_package ?? 'Paket');
        }

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
