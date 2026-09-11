<?php

namespace App\Rules;

use App\Support\LeadGuard;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DeliverableEmail implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! LeadGuard::isDeliverableEmail(is_string($value) ? $value : null)) {
            $fail('Bitte geben Sie eine gültige E-Mail-Adresse ein (z. B. name@beispiel.ch).');
        }
    }
}
