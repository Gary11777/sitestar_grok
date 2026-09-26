<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactInquiry extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $senderName,
        public string $senderEmail,
        public ?string $phone,
        public string $topic,
        public string $inquiry,
    ) {}

    /**
     * The studio address stays in From. Reply-To is the visitor, so a reply
     * from the inbox goes to the person who wrote, not back to the studio.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [
                new Address($this->senderEmail, $this->senderName),
            ],
            subject: 'SiteStar inquiry: '.$this->topic,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.contact-inquiry',
            text: 'mail.contact-inquiry-text',
        );
    }
}
