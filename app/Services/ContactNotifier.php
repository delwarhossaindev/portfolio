<?php

namespace App\Services;

use App\Mail\ContactReceived;
use App\Mail\ContactSubmitted;
use App\Models\Contact;
use App\Models\PortfolioContent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Emails for a new contact-form message: a notification to the site owner
 * (To + optional CC) and an optional thank-you to the visitor. Failures are
 * logged, never thrown, so a mail outage can't lose the stored message.
 */
class ContactNotifier
{
    public function send(Contact $contact): void
    {
        $owner = PortfolioContent::current();

        $this->notifyOwner($contact, $owner);

        if (config('mail.contact.auto_reply')) {
            $this->thankVisitor($contact, $owner);
        }
    }

    private function notifyOwner(Contact $contact, PortfolioContent $owner): void
    {
        $to = config('mail.contact.to') ?: $owner->contact_email;
        if (! $to) {
            return;
        }

        try {
            $mail = Mail::to($to);

            $cc = config('mail.contact.cc');
            if ($cc && strcasecmp($cc, $to) !== 0) {
                $mail->cc($cc);
            }

            $mail->send(new ContactSubmitted($contact));
        } catch (\Throwable $e) {
            Log::error('Contact notification email failed', [
                'contact_id' => $contact->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function thankVisitor(Contact $contact, PortfolioContent $owner): void
    {
        try {
            Mail::to($contact->email, $contact->name)->send(new ContactReceived($contact, $owner));
        } catch (\Throwable $e) {
            Log::warning('Contact auto-reply email failed', [
                'contact_id' => $contact->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
