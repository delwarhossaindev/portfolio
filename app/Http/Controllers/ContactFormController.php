<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;
use App\Services\ContactNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

/**
 * The public "Have a project in mind?" form. Answers JSON for the AJAX form
 * and a redirect for browsers without JavaScript.
 */
class ContactFormController extends Controller
{
    private const MAX_PER_HOUR = 3;

    private const SUCCESS = 'Message sent successfully! I will get back to you soon.';

    public function store(ContactFormRequest $request, ContactNotifier $notifier)
    {
        // Honeypot: real visitors never see the "website" field, bots fill it.
        // Pretend it worked so the bot doesn't retry.
        if (filled($request->input('website'))) {
            return $this->respond($request, self::SUCCESS);
        }

        $rateKey = 'contact:' . $request->ip();
        if (RateLimiter::tooManyAttempts($rateKey, self::MAX_PER_HOUR)) {
            $minutes = (int) ceil(RateLimiter::availableIn($rateKey) / 60);

            return $this->respond($request, "Too many messages sent. Please try again in {$minutes} minutes.", 429);
        }
        RateLimiter::hit($rateKey, 3600);

        $contact = Contact::create($request->validated() + ['ip_address' => $request->ip()]);

        // Email after the response is sent, so the visitor isn't kept waiting on the mail server.
        app()->terminating(fn () => $notifier->send($contact));

        return $this->respond($request, self::SUCCESS);
    }

    private function respond(Request $request, string $message, int $status = 200)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message], $status);
        }

        return $status === 200
            ? back()->with('success', $message)
            : back()->withInput()->withErrors(['message' => $message]);
    }
}
