<?php

namespace Tests\Feature;

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
