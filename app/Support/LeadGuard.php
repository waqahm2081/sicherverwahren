<?php

namespace App\Support;

class LeadGuard
{
    /** Domains that look valid to HTML5 but are not deliverable / test junk. */
    public const BLOCKED_DOMAINS = [
        'test',
        'testing',
        'example',
        'example.com',
        'example.org',
        'example.net',
        'localhost',
        'invalid',
        'email.com',
        'mail.com',
        'test.com',
        'test.ch',
        'asdf.com',
        'mailinator.com',
        'guerrillamail.com',
        'tempmail.com',
        '10minutemail.com',
        'yopmail.com',
        'trashmail.com',
    ];

    public static function isDeliverableEmail(?string $email): bool
    {
        $email = strtolower(trim((string) $email));

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $domain = substr(strrchr($email, '@'), 1) ?: '';

        if ($domain === '' || ! str_contains($domain, '.')) {
            return false; // e.g. test@test
        }

        if (in_array($domain, self::BLOCKED_DOMAINS, true)) {
            return false;
        }

        $tld = substr(strrchr($domain, '.'), 1) ?: '';
        if (strlen($tld) < 2 || ! ctype_alpha($tld)) {
            return false;
        }

        // No MX / A record → undeliverable (blocks many bot domains)
        if (! checkdnsrr($domain, 'MX') && ! checkdnsrr($domain, 'A')) {
            return false;
        }

        return true;
    }

    public static function looksLikeSpamName(?string $name): bool
    {
        $name = trim((string) $name);

        if (mb_strlen($name) < 2) {
            return true;
        }

        if (preg_match('/https?:\/\/|www\.|<.*>/i', $name)) {
            return true;
        }

        // Mostly digits / random keyboard spam
        if (preg_match('/^[a-z0-9]{12,}$/i', str_replace(' ', '', $name))) {
            return true;
        }

        return false;
    }
}
