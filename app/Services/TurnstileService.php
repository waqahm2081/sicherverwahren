<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TurnstileService
{
    public function isEnabled(): bool
    {
        return filled(config('services.turnstile.secret'))
            && filled(config('services.turnstile.site_key'));
    }

    public function siteKey(): ?string
    {
        return config('services.turnstile.site_key');
    }

    /**
     * Returns null when Turnstile is disabled (optional).
     * Returns true/false when enabled.
     */
    public function verify(Request $request): ?bool
    {
        if (! $this->isEnabled()) {
            return null;
        }

        $token = $request->input('cf-turnstile-response');
        if (! $token) {
            return false;
        }

        $response = Http::asForm()->timeout(8)->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            [
                'secret'   => config('services.turnstile.secret'),
                'response' => $token,
                'remoteip' => $request->ip(),
            ]
        );

        return (bool) $response->json('success');
    }
}
