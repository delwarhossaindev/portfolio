<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\PortfolioContent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

/**
 * Auto-reply to the visitor. It deliberately never echoes the visitor's
 * subject or message, so the form can't be used to relay spam to a
 * third party by typing their address into the email field.
 */
class ContactReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Contact $contact, public PortfolioContent $owner)
    {
    }

    public function envelope(): Envelope
    {
        $replyTo = config('mail.contact.to') ?: $this->owner->contact_email;

        return new Envelope(
            subject: 'Thanks for getting in touch — ' . $this->owner->hero_name,
            replyTo: $replyTo ? [new Address($replyTo, $this->owner->hero_name)] : [],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-received',
            text: 'emails.contact-received-text',
            with: [
                'greetingName' => $this->greetingName(),
                'owner' => $this->owner,
            ],
        );
    }

    private function greetingName(): string
    {
        $first = Str::before(trim($this->contact->name), ' ') ?: 'there';

        // Letters only, kept short, so the name field can't carry a spam payload.
        $first = preg_replace('/[^\p{L}\p{M}\'-]/u', '', $first) ?: 'there';

        return Str::limit($first, 30, '');
    }
}
