<?php

namespace Tests\Feature;

use App\Mail\ContactReceived;
use App\Mail\ContactSubmitted;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    private array $valid = [
        'name' => 'Jane Visitor',
        'email' => 'jane@example.com',
        'subject' => 'Project enquiry',
        'message' => 'Hello, I would like to discuss a project with you.',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        config(['mail.contact.to' => 'inbox@example.com', 'mail.contact.cc' => 'copy@example.com']);
    }

    public function test_ajax_submission_stores_message_and_emails_with_cc(): void
    {
        $this->postJson('/contact', $this->valid)
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertDatabaseHas('contacts', ['email' => 'jane@example.com', 'is_read' => false]);

        Mail::assertSent(ContactSubmitted::class, fn ($mail) =>
            $mail->hasTo('inbox@example.com') && $mail->hasCc('copy@example.com'));
    }

    public function test_visitor_gets_an_auto_reply_that_never_echoes_their_input(): void
    {
        $this->postJson('/contact', [
            'name' => 'Jane <a href="http://spam.example">WIN</a>',
            'email' => 'jane@example.com',
            'subject' => 'Cheap pills at spam.example',
            'message' => 'Visit http://spam.example now for great deals!!!',
        ])->assertOk();

        Mail::assertSent(ContactReceived::class, function (ContactReceived $mail) {
            $html = $mail->render();

            return $mail->hasTo('jane@example.com')
                && $mail->hasReplyTo('inbox@example.com')
                && str_contains($html, 'Jane')
                && ! str_contains($html, 'spam.example')
                && ! str_contains($html, 'Cheap pills');
        });
    }

    public function test_auto_reply_can_be_turned_off(): void
    {
        config(['mail.contact.auto_reply' => false]);

        $this->postJson('/contact', $this->valid)->assertOk();

        Mail::assertSent(ContactSubmitted::class);
        Mail::assertNotSent(ContactReceived::class);
    }

    public function test_notification_email_has_html_and_plain_text_parts(): void
    {
        $this->postJson('/contact', $this->valid)->assertOk();

        Mail::assertSent(ContactSubmitted::class, function (ContactSubmitted $mail) {
            [$html, $text] = [$mail->render(), view('emails.contact-submitted-text', ['contact' => $mail->contact])->render()];

            return str_contains($html, 'Project enquiry')
                && str_contains($html, 'Open in dashboard')
                && str_contains($text, 'Jane Visitor <jane@example.com>');
        });
    }

    public function test_whitespace_only_fields_are_rejected(): void
    {
        $this->postJson('/contact', ['name' => '   ', 'email' => 'jane@example.com', 'subject' => '   ', 'message' => str_repeat(' ', 20)])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'subject', 'message']);
    }

    public function test_ajax_validation_errors_return_422_with_field_errors(): void
    {
        $this->postJson('/contact', ['name' => 'a', 'email' => 'not-an-email'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'subject', 'message']);

        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_honeypot_pretends_success_but_stores_nothing(): void
    {
        $this->postJson('/contact', $this->valid + ['website' => 'http://spam.example'])
            ->assertOk();

        $this->assertDatabaseCount('contacts', 0);
        Mail::assertNothingSent();
    }

    public function test_more_than_three_messages_per_hour_are_rejected(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $this->postJson('/contact', $this->valid)->assertOk();
        }

        $this->postJson('/contact', $this->valid)->assertStatus(429);
        $this->assertSame(3, Contact::count());
    }

    public function test_classic_form_post_still_redirects(): void
    {
        $this->from('/')->post('/contact', $this->valid)
            ->assertRedirect('/')
            ->assertSessionHas('success');
    }
}
