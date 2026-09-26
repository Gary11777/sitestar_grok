<?php

namespace App\Rules;

use App\Services\TurnstileVerifier;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;

/**
 * Server-side Turnstile check.
 *
 * Skipped when the honeypot is filled. Those submissions are discarded later
 * and should look like an ordinary success, not a failed captcha.
 */
class Turnstile implements ValidationRule
{
    public function __construct(private Request $request) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->request->filled('company_url')) {
            return;
        }

        $token = is_string($value) ? $value : null;

        if (! app(TurnstileVerifier::class)->passes($token, $this->request->ip())) {
            $fail('We could not confirm this submission. Please try again.');
        }
    }
}
