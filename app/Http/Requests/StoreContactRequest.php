<?php

namespace App\Http\Requests;

use App\Rules\Turnstile;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * CSRF is enforced by the web middleware before this request is resolved.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40', 'regex:/^[0-9+().\-\s]+$/'],
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'company_url' => ['nullable', 'string', 'max:255'],
            'turnstile_token' => ['nullable', 'string', new Turnstile($this)],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.regex' => 'Enter a phone number using digits and the usual symbols only.',
            'message.min' => 'Please write a short note, at least a sentence.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $honeypot = $this->input('company_url');

        $this->merge([
            'name' => $this->singleLine($this->sanitize($this->input('name'))),
            'email' => $this->singleLine($this->sanitize($this->input('email'))),
            'phone' => $this->emptyToNull($this->singleLine($this->sanitize($this->input('phone')))),
            'subject' => $this->singleLine($this->sanitize($this->input('subject'))),
            'message' => $this->sanitize($this->input('message')),
            // A non-string honeypot value still counts as filled, so the
            // controller can drop the submission without sending mail.
            'company_url' => is_string($honeypot)
                ? trim($honeypot)
                : (empty($honeypot) ? '' : 'filled'),
        ]);
    }

    private function sanitize(mixed $value): string
    {
        if (! is_string($value)) {
            return '';
        }

        $value = str_replace("\0", '', $value);

        $stripped = preg_replace('/<(script|style)\b[^>]*>.*?<\/\1>/is', '', $value);

        return trim(strip_tags(is_string($stripped) ? $stripped : $value));
    }

    private function singleLine(string $value): string
    {
        $collapsed = preg_replace('/\s+/', ' ', $value);

        return trim(is_string($collapsed) ? $collapsed : $value);
    }

    private function emptyToNull(string $value): ?string
    {
        return $value === '' ? null : $value;
    }
}
