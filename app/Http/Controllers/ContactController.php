<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class ContactController extends Controller
{
    public function create(Request $request): Response
    {
        $siteKey = config('services.turnstile.site_key');
        $status = $request->session()->get('contact_status');

        return Inertia::render('Contact', [
            'siteKey' => is_string($siteKey) && $siteKey !== '' ? $siteKey : null,
            'status' => is_string($status) ? $status : null,
        ]);
    }

    /**
     * Accept a contact note.
     *
     * Order of defence: CSRF middleware, rate limiter, server-side validation
     * (including Turnstile), then the honeypot. A filled honeypot returns the
     * same response as a real message and does not send mail.
     */
    public function store(StoreContactRequest $request): RedirectResponse
    {
        if ($request->filled('company_url')) {
            return $this->accepted();
        }

        /** @var array{name: string, email: string, phone: ?string, subject: string, message: string} $data */
        $data = $request->safe()->only(['name', 'email', 'phone', 'subject', 'message']);

        $inbox = config('mail.from.address');

        if (! is_string($inbox) || $inbox === '') {
            return back()->withErrors([
                'form' => 'The studio mailbox is not configured yet. Please try again later.',
            ]);
        }

        try {
            Mail::to($inbox)->send(new ContactInquiry(
                senderName: $data['name'],
                senderEmail: $data['email'],
                phone: $data['phone'],
                topic: $data['subject'],
                inquiry: $data['message'],
            ));
        } catch (Throwable $exception) {
            report($exception);

            return back()->withErrors([
                'form' => 'We could not send your message. Please try again in a moment.',
            ]);
        }

        return $this->accepted();
    }

    private function accepted(): RedirectResponse
    {
        return to_route('contact')->with('contact_status', 'sent');
    }
}
