<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

/**
 * Checks a Cloudflare Turnstile token with the Siteverify API.
 *
 * The widget is invisible (interaction-only) in the browser. This class is the
 * part that actually decides whether a submission is allowed. A token is
 * single-use and expires after five minutes, so the browser must fetch a new
 * one after every attempt.
 */
class TurnstileVerifier
{
    private const VERIFY_URL = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

    public function passes(?string $token, ?string $ip): bool
    {
        $secret = config('services.turnstile.secret');

        if (! is_string($secret) || $secret === '') {
            // Fail closed once the app is deployed. Local and test runs can
            // submit the form before Cloudflare keys exist.
            return app()->environment('local', 'testing');
        }

        if ($token === null || $token === '') {
            return false;
        }

        try {
            $response = Http::asForm()
                ->timeout(8)
                ->post(self::VERIFY_URL, [
                    'secret' => $secret,
                    'response' => $token,
                    'remoteip' => $ip,
                ]);
        } catch (ConnectionException) {
            return false;
        }

        return $response->ok() && $response->json('success') === true;
    }
}
