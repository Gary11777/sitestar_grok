<?php

use App\Mail\ContactInquiry;
use App\Services\TurnstileVerifier;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Inertia\Testing\AssertableInertia as Assert;

function validContactPayload(array $overrides = []): array
{
    return array_merge([
        'name' => 'Ada Marin',
        'email' => 'ada@example.com',
        'phone' => '+375 29 111-22-33',
        'subject' => 'A new marketing site',
        'message' => 'We need a clear site for a small product team.',
        'company_url' => '',
        'turnstile_token' => '',
    ], $overrides);
}

beforeEach(function () {
    Mail::fake();
    RateLimiter::clear(md5('contact127.0.0.1'));
});

test('marketing pages render', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Home')
            ->has('projects', 3));

    $this->get(route('about'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('About'));

    $this->get(route('portfolio'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Portfolio')
            ->has('projects', 3)
            ->where('projects.0.url', 'https://dimgent.com/')
            ->where('projects.1.url', 'https://dimgent.by/')
            ->where('projects.2.url', 'https://gradiometr.com/'));

    $this->get(route('contact'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Contact')
            ->where('siteKey', null));
});

test('contact form validates required fields', function () {
    $this->post(route('contact.store'), validContactPayload([
        'name' => '',
        'email' => 'not-an-email',
        'message' => 'short',
    ]))->assertSessionHasErrors(['name', 'email', 'message']);

    Mail::assertNothingSent();
});

test('contact form strips markup and sends mail', function () {
    config(['mail.from.address' => 'info@sitestar.by']);

    $this->post(route('contact.store'), validContactPayload([
        'name' => "Ada <script>alert(1)</script>\nMarin",
        'subject' => "Hello\r\nBcc: spam@example.com",
    ]))->assertRedirect(route('contact'));

    Mail::assertSent(ContactInquiry::class, function (ContactInquiry $mail): bool {
        return $mail->hasTo('info@sitestar.by')
            && $mail->senderName === 'Ada Marin'
            && $mail->topic === 'Hello Bcc: spam@example.com'
            && $mail->hasReplyTo('ada@example.com');
    });
});

test('a filled honeypot does not send mail', function () {
    $this->post(route('contact.store'), validContactPayload([
        'company_url' => 'https://spam.example',
    ]))
        ->assertRedirect(route('contact'))
        ->assertSessionHas('contact_status', 'sent');

    Mail::assertNothingSent();
});

test('turnstile rejection blocks the message', function () {
    config(['services.turnstile.secret' => 'test-secret']);

    Http::fake([
        'challenges.cloudflare.com/*' => Http::response([
            'success' => false,
            'error-codes' => ['invalid-input-response'],
        ]),
    ]);

    $this->post(route('contact.store'), validContactPayload([
        'turnstile_token' => 'bad-token',
    ]))->assertSessionHasErrors('turnstile_token');

    Mail::assertNothingSent();
});

test('a verified turnstile token sends mail', function () {
    config([
        'services.turnstile.secret' => 'test-secret',
        'mail.from.address' => 'info@sitestar.by',
    ]);

    Http::fake([
        'challenges.cloudflare.com/*' => Http::response(['success' => true]),
    ]);

    $this->post(route('contact.store'), validContactPayload([
        'turnstile_token' => 'token-ok',
    ]))->assertRedirect(route('contact'));

    Mail::assertSent(ContactInquiry::class);
    Http::assertSent(fn ($request): bool => $request['response'] === 'token-ok'
        && $request['secret'] === 'test-secret');
});

test('turnstile fails closed without a secret in production', function () {
    $this->app['env'] = 'production';
    config(['services.turnstile.secret' => null]);

    expect(app(TurnstileVerifier::class)->passes('token', '127.0.0.1'))->toBeFalse();
});

test('contact submissions are rate limited', function () {
    foreach (range(1, 5) as $attempt) {
        $this->post(route('contact.store'), validContactPayload())
            ->assertRedirect(route('contact'));
    }

    $this->post(route('contact.store'), validContactPayload())
        ->assertSessionHasErrors('form');
});
